<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Http;

use Psr\SimpleCache\CacheInterface;

/**
 * PSR-16 caching decorator for NBA HTTP requests.
 */
final class CachingNbaHttpClient implements NbaHttpClientInterface
{
    private const string CACHE_PREFIX = 'nba_live.http.';

    public function __construct(
        private readonly NbaHttpClientInterface $inner,
        private readonly CacheInterface $cache,
        private readonly int $defaultTtl = 300,
    ) {
    }

    public function get(string $url, ?int $ttl = null): NbaHttpResponse
    {
        $cacheKey = self::CACHE_PREFIX . hash('sha256', $url);
        $cached = $this->cache->get($cacheKey);

        if (is_array($cached)) {
            return new NbaHttpResponse(
                url: (string) ($cached['url'] ?? $url),
                statusCode: (int) ($cached['statusCode'] ?? 200),
                body: (string) ($cached['body'] ?? ''),
                size: (int) ($cached['size'] ?? 0),
                connectTime: (float) ($cached['connectTime'] ?? 0.0),
                ip: (string) ($cached['ip'] ?? ''),
            );
        }

        $response = $this->inner->get($url);

        if ($response->isSuccessful()) {
            $this->cache->set($cacheKey, [
                'url' => $response->url,
                'statusCode' => $response->statusCode,
                'body' => $response->body,
                'size' => $response->size,
                'connectTime' => $response->connectTime,
                'ip' => $response->ip,
            ], $ttl ?? $this->defaultTtl);
        }

        return $response;
    }
}
