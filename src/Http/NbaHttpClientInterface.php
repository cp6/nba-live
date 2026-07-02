<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Http;

/**
 * Contract for HTTP clients used to call NBA API endpoints.
 */
interface NbaHttpClientInterface
{
    /**
     * Execute a GET request against the given URL.
     *
     * @throws \Corbpie\NBALive\NBAApiException When the transport layer fails
     */
    public function get(string $url): NbaHttpResponse;
}
