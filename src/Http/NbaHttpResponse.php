<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Http;

/**
 * Immutable HTTP response from an NBA API request.
 */
final readonly class NbaHttpResponse
{
    public function __construct(
        public string $url,
        public int $statusCode,
        public string $body,
        public int $size,
        public float $connectTime,
        public string $ip,
    ) {
    }

    public function isSuccessful(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }
}
