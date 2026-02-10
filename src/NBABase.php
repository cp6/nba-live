<?php

namespace Corbpie\NBALive;

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

    // Player status constants
    public const STATUS_INACTIVE = 'INACTIVE';
    public const STATUS_ACTIVE = 'ACTIVE';

    // Game status constants
    public const GAME_STATUS_NOT_STARTED = 1;
    public const GAME_STATUS_IN_PROGRESS = 2;
    public const GAME_STATUS_COMPLETED = 3;

    // Quarter duration in seconds
    public const QUARTER_DURATION_SECONDS = 720;
    public const OT_DURATION_SECONDS = 300;

    /** @var string The URL used for the last API call */
    public string $url;

    /** @var int HTTP response code from the last API call */
    public int $response_code;

    /** @var int Size of the response in bytes */
    public int $response_size;

    /** @var float Time taken to connect in seconds */
    public float $connect_time;

    /** @var string IP address of the API endpoint */
    public string $ip;

    /** @var bool|string Raw response body from the last API call */
    public bool|string $response_body = '';

    /** @var string Game identifier */
    public string $game_id;

    /** @var int Player identifier */
    public int $player_id;

    /** @var int Team identifier */
    public int $team_id;

    /**
     * Initialize the base class and set JSON content type header.
     */
    public function __construct()
    {
        header('Content-Type: application/json');
    }

    /**
     * Make an API call to the NBA API.
     *
     * @param string $url The API endpoint URL
     * @return array Decoded JSON response
     * @throws NBAApiException When the API request fails (non-2xx response)
     */
    protected function ApiCall(string $url): array
    {
        $this->url = $url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[1] = "Accept-Language: en-us,en;q=0.5";
        curl_setopt($curl, CURLOPT_REFERER, "https://stats.nba.com/");
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:120.0) Gecko/20100101 Firefox/120.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $this->response_body = curl_exec($curl);
        $this->response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->response_size = curl_getinfo($curl, CURLINFO_SIZE_DOWNLOAD);
        $this->connect_time = curl_getinfo($curl, CURLINFO_CONNECT_TIME);
        $this->ip = curl_getinfo($curl, CURLINFO_PRIMARY_IP);

        curl_close($curl);

        if ($this->response_code >= 200 && $this->response_code < 300) {
            return json_decode($this->response_body, true) ?? [];
        }

        throw new NBAApiException(
            "NBA API request failed with HTTP code {$this->response_code}",
            $this->response_code,
            json_decode($this->response_body, true)
        );
    }


    /**
     * Convert game time in seconds to a formatted game time array.
     *
     * @param float $seconds Total seconds elapsed in the game
     * @return array{period: int, period_string: string, seconds: float, seconds_period: int, seconds_period_string: string, string: string, full_string: string}
     */
    public static function secondsToFormattedGameTime(float $seconds): array
    {
        $seconds = round($seconds);

        // Define period boundaries
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
            'seconds_period' => (int)$seconds_in,
            'seconds_period_string' => gmdate('i:s', (int)$seconds_out),
            'string' => gmdate('i:s', (int)$seconds_in),
            'full_string' => $period_txt . ' ' . gmdate('i:s', (int)$seconds_out)
        ];
    }

    /**
     * Convert height in feet-inches format to centimeters.
     *
     * @param string $feetInches Height in "feet-inches" format (e.g., "6-8")
     * @return int Height in centimeters
     */
    public function feetInchesToCm(string $feetInches): int
    {
        $array = explode('-', $feetInches);
        if (isset($array[1])) {
            return (int)number_format(($array[0] * 30.48) + ($array[1] * 2.54), 0);
        }
        return (int)number_format(($array[0] * 30.48), 0);
    }

    /**
     * Sort player data array in ascending order by a statistics key.
     *
     * @param array $players_data Array of player data
     * @param string $key Statistics key to sort by (default: 'points')
     * @return array Sorted player data
     */
    public function sortPlayersAsc(array $players_data, string $key = 'points'): array
    {
        usort($players_data, fn($a, $b) => $a['statistics'][$key] <=> $b['statistics'][$key]);
        return $players_data;
    }

    /**
     * Sort player data array in descending order by a statistics key.
     *
     * @param array $players_data Array of player data
     * @param string $key Statistics key to sort by (default: 'points')
     * @return array Sorted player data
     */
    public function sortPlayersDesc(array $players_data, string $key = 'points'): array
    {
        usort($players_data, fn($a, $b) => $b['statistics'][$key] <=> $a['statistics'][$key]);
        return $players_data;
    }

    /**
     * Validate that a required string parameter is not empty.
     *
     * @param string $value The value to validate
     * @param string $paramName The parameter name for error messages
     * @throws \InvalidArgumentException When the value is empty
     */
    protected function validateRequiredString(string $value, string $paramName): void
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException("{$paramName} is required and cannot be empty");
        }
    }

    /**
     * Validate that a required integer parameter is positive.
     *
     * @param int $value The value to validate
     * @param string $paramName The parameter name for error messages
     * @throws \InvalidArgumentException When the value is not positive
     */
    protected function validatePositiveInt(int $value, string $paramName): void
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException("{$paramName} must be a positive integer");
        }
    }

    /**
     * Safely get a nested array value with a default.
     *
     * @param array $array The array to search
     * @param array $keys Array of keys representing the path
     * @param mixed $default Default value if path doesn't exist
     * @return mixed The value at the path or the default
     */
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
