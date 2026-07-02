<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Http\CurlNbaHttpClient;
use Corbpie\NBALive\Http\NbaHttpClientInterface;
use Corbpie\NBALive\Http\NbaHttpResponse;
use JsonException;

/**
 * Base class for all NBA API wrapper classes.
 * Provides common functionality including API calls, constants, and utility methods.
 */
class NBABase
{
    /** @var string Current NBA season identifier */
    public const CURRENT_SEASON = '2025-26';

    /** @var string Previous NBA season identifier */
    public const PREVIOUS_SEASON = '2024-25';

    /** @var string Per game statistics mode */
    public const MODE_PER_GAME = 'PerGame';

    /** @var string Total statistics mode */
    public const MODE_TOTAL = 'Totals';

    /** @var string Per 48 minutes statistics mode */
    public const MODE_PER48 = 'Per48';

    /** @var string Current season type */
    public const CURRENT_TYPE = 'Regular+Season';

    /** @var string Regular season type */
    public const TYPE_REGULAR = 'Regular+Season';

    /** @var string Play-in tournament type */
    public const TYPE_PLAY_IN = 'PlayIn';

    /** @var string Playoffs type */
    public const TYPE_PLAYOFFS = 'Playoffs';

    /** @var string All-Star game type */
    public const TYPE_ALL_STAR = 'All+Star';

    /** @var string Pre-season type */
    public const TYPE_PRE_SEASON = 'Pre+Season';

    public const STATUS_INACTIVE = 'INACTIVE';
    public const STATUS_ACTIVE = 'ACTIVE';

    public const GAME_STATUS_NOT_STARTED = 1;
    public const GAME_STATUS_IN_PROGRESS = 2;
    public const GAME_STATUS_COMPLETED = 3;

    public const QUARTER_DURATION_SECONDS = 720;
    public const OT_DURATION_SECONDS = 300;

    public string $url = '';

    public int $response_code = 0;

    public int $response_size = 0;

    public float $connect_time = 0.0;

    public string $ip = '';

    public string $response_body = '';

    public string $game_id = '';

    public int $player_id = 0;

    public int $team_id = 0;

    private ?NbaHttpClientInterface $httpClient = null;

    public function __construct(?NbaHttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Inject a custom HTTP client (useful for testing or PSR-18 adapters).
     */
    public function setHttpClient(NbaHttpClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    protected function getHttpClient(): NbaHttpClientInterface
    {
        return $this->httpClient ??= new CurlNbaHttpClient();
    }

    /**
     * Make an API call to the NBA API.
     *
     * @return array<string, mixed> Decoded JSON response
     * @throws NBAApiException When the API request fails (non-2xx response or transport error)
     * @throws JsonException When the response body is not valid JSON
     */
    protected function ApiCall(string $url): array
    {
        $response = $this->getHttpClient()->get($url);
        $this->applyResponseMetadata($response);

        if (!$response->isSuccessful()) {
            throw new NBAApiException(
                "NBA API request failed with HTTP code {$response->statusCode}",
                $response->statusCode,
                $this->decodeJson($response->body, allowInvalid: true),
            );
        }

        return $this->decodeJson($response->body);
    }

    /**
     * @return array<string, mixed>
     * @throws JsonException
     */
    private function decodeJson(string $body, bool $allowInvalid = false): array
    {
        if ($body === '') {
            return [];
        }

        try {
            $decoded = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            if ($allowInvalid) {
                return [];
            }

            throw $exception;
        }

        return is_array($decoded) ? $decoded : [];
    }

    private function applyResponseMetadata(NbaHttpResponse $response): void
    {
        $this->url = $response->url;
        $this->response_code = $response->statusCode;
        $this->response_size = $response->size;
        $this->connect_time = $response->connectTime;
        $this->ip = $response->ip;
        $this->response_body = $response->body;
    }

    /**
     * @return array{period: int, period_string: string, seconds: float, seconds_period: int, seconds_period_string: string, string: string, full_string: string}
     */
    public static function secondsToFormattedGameTime(float $seconds): array
    {
        $seconds = round($seconds);

        $periods = [
            1 => ['max' => self::QUARTER_DURATION_SECONDS, 'offset' => 0, 'label' => 'Q1'],
            2 => ['max' => self::QUARTER_DURATION_SECONDS * 2, 'offset' => self::QUARTER_DURATION_SECONDS, 'label' => 'Q2'],
            3 => ['max' => self::QUARTER_DURATION_SECONDS * 3, 'offset' => self::QUARTER_DURATION_SECONDS * 2, 'label' => 'Q3'],
            4 => ['max' => self::QUARTER_DURATION_SECONDS * 4, 'offset' => self::QUARTER_DURATION_SECONDS * 3, 'label' => 'Q4'],
            5 => ['max' => self::QUARTER_DURATION_SECONDS * 4 + self::OT_DURATION_SECONDS, 'offset' => self::QUARTER_DURATION_SECONDS * 4, 'label' => 'OT1'],
            6 => ['max' => self::QUARTER_DURATION_SECONDS * 4 + self::OT_DURATION_SECONDS * 2, 'offset' => self::QUARTER_DURATION_SECONDS * 4 + self::OT_DURATION_SECONDS, 'label' => 'OT2'],
            7 => ['max' => self::QUARTER_DURATION_SECONDS * 4 + self::OT_DURATION_SECONDS * 3, 'offset' => self::QUARTER_DURATION_SECONDS * 4 + self::OT_DURATION_SECONDS * 2, 'label' => 'OT3'],
            8 => ['max' => PHP_INT_MAX, 'offset' => self::QUARTER_DURATION_SECONDS * 4 + self::OT_DURATION_SECONDS * 3, 'label' => 'OT4'],
        ];

        $period = 1;
        $period_txt = 'Q1';
        $seconds_in = $seconds;

        foreach ($periods as $p => $config) {
            if ($seconds <= $config['max']) {
                $period = $p;
                $period_txt = $config['label'];
                $seconds_in = $seconds - $config['offset'];
                break;
            }
        }

        $period_duration = ($period <= 4) ? self::QUARTER_DURATION_SECONDS : self::OT_DURATION_SECONDS;
        $seconds_out = $period_duration - $seconds_in;

        return [
            'period' => $period,
            'period_string' => $period_txt,
            'seconds' => $seconds,
            'seconds_period' => (int) $seconds_in,
            'seconds_period_string' => gmdate('i:s', (int) $seconds_out),
            'string' => gmdate('i:s', (int) $seconds_in),
            'full_string' => $period_txt . ' ' . gmdate('i:s', (int) $seconds_out),
        ];
    }

    public function feetInchesToCm(string $feetInches): int
    {
        $array = explode('-', $feetInches);

        if (isset($array[1])) {
            return (int) round(((int) $array[0] * 30.48) + ((int) $array[1] * 2.54));
        }

        return (int) round((int) $array[0] * 30.48);
    }

    /**
     * @param list<array<string, mixed>> $players_data
     * @return list<array<string, mixed>>
     */
    public function sortPlayersAsc(array $players_data, string $key = 'points'): array
    {
        usort($players_data, fn ($a, $b) => $a['statistics'][$key] <=> $b['statistics'][$key]);

        return $players_data;
    }

    /**
     * @param list<array<string, mixed>> $players_data
     * @return list<array<string, mixed>>
     */
    public function sortPlayersDesc(array $players_data, string $key = 'points'): array
    {
        usort($players_data, fn ($a, $b) => $b['statistics'][$key] <=> $a['statistics'][$key]);

        return $players_data;
    }

    protected function validateRequiredString(string $value, string $paramName): void
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException("{$paramName} is required and cannot be empty");
        }
    }

    protected function validatePositiveInt(int $value, string $paramName): void
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException("{$paramName} must be a positive integer");
        }
    }

    protected function getNestedValue(array $array, array $keys, mixed $default = null): mixed
    {
        foreach ($keys as $key) {
            if (!is_array($array) || !array_key_exists($key, $array)) {
                return $default;
            }

            $array = $array[$key];
        }

        return $array;
    }
}
