<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Http;

use Corbpie\NBALive\NBAApiException;

/**
 * Retrying decorator for transient NBA HTTP/transport failures.
 */
final class RetryNbaHttpClient implements NbaHttpClientInterface
{
    public function __construct(
        private readonly NbaHttpClientInterface $inner,
        private readonly int $maxAttempts = 3,
        private readonly int $baseDelayMs = 250,
        /** @var list<int> */
        private readonly array $retryStatusCodes = [408, 425, 429, 500, 502, 503, 504],
    ) {
        if ($this->maxAttempts < 1) {
            throw new \InvalidArgumentException('maxAttempts must be at least 1');
        }
    }

    public function get(string $url): NbaHttpResponse
    {
        $attempt = 0;
        $lastException = null;

        while ($attempt < $this->maxAttempts) {
            $attempt++;

            try {
                $response = $this->inner->get($url);

                if ($response->isSuccessful() || !$this->shouldRetryStatus($response->statusCode) || $attempt >= $this->maxAttempts) {
                    return $response;
                }
            } catch (NBAApiException $exception) {
                $lastException = $exception;

                if ($attempt >= $this->maxAttempts) {
                    throw $exception;
                }
            }

            usleep($this->baseDelayMs * (2 ** ($attempt - 1)) * 1000);
        }

        if ($lastException instanceof NBAApiException) {
            throw $lastException;
        }

        throw new NBAApiException("NBA API request failed after {$this->maxAttempts} attempts");
    }

    private function shouldRetryStatus(int $statusCode): bool
    {
        return in_array($statusCode, $this->retryStatusCodes, true);
    }
}
