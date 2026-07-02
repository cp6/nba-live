<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Tests;

use Corbpie\NBALive\Http\NbaHttpClientInterface;
use Corbpie\NBALive\Http\NbaHttpResponse;

/**
 * In-memory HTTP client for unit tests.
 */
final class MockNbaHttpClient implements NbaHttpClientInterface
{
    /** @var array<string, NbaHttpResponse> */
    private array $responses = [];

    public function register(string $url, NbaHttpResponse $response): void
    {
        $this->responses[$url] = $response;
    }

    public function get(string $url): NbaHttpResponse
    {
        if (!isset($this->responses[$url])) {
            throw new \RuntimeException("No mock response registered for URL: {$url}");
        }

        return $this->responses[$url];
    }
}
