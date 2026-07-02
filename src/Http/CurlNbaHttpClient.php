<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Http;

use Corbpie\NBALive\NBAApiException;

/**
 * cURL-based HTTP client for NBA API endpoints.
 */
final class CurlNbaHttpClient implements NbaHttpClientInterface
{
    private const int CONNECT_TIMEOUT_SECONDS = 10;

    private const int TOTAL_TIMEOUT_SECONDS = 30;

    private const string DEFAULT_USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:120.0) Gecko/20100101 Firefox/120.0';

    private const string DEFAULT_REFERER = 'https://stats.nba.com/';

    public function __construct(
        private readonly int $connectTimeout = self::CONNECT_TIMEOUT_SECONDS,
        private readonly int $totalTimeout = self::TOTAL_TIMEOUT_SECONDS,
        private readonly string $userAgent = self::DEFAULT_USER_AGENT,
        private readonly string $referer = self::DEFAULT_REFERER,
    ) {
    }

    public function get(string $url): NbaHttpResponse
    {
        $curl = curl_init();

        if ($curl === false) {
            throw new NBAApiException('Failed to initialize cURL');
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => [
                'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
                'Accept-Language: en-us,en;q=0.5',
            ],
            CURLOPT_REFERER => $this->referer,
            CURLOPT_USERAGENT => $this->userAgent,
            CURLOPT_ENCODING => 'gzip,deflate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_TIMEOUT => $this->totalTimeout,
        ]);

        $body = curl_exec($curl);

        if ($body === false) {
            $error = curl_error($curl);
            $errno = curl_errno($curl);
            curl_close($curl);

            throw new NBAApiException("cURL request failed: {$error}", $errno);
        }

        $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $size = (int) curl_getinfo($curl, CURLINFO_SIZE_DOWNLOAD);
        $connectTime = (float) curl_getinfo($curl, CURLINFO_CONNECT_TIME);
        $ip = (string) curl_getinfo($curl, CURLINFO_PRIMARY_IP);

        curl_close($curl);

        return new NbaHttpResponse(
            url: $url,
            statusCode: $statusCode,
            body: $body,
            size: $size,
            connectTime: $connectTime,
            ip: $ip,
        );
    }
}
