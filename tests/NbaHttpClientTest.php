<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Tests;

use Corbpie\NBALive\Http\NbaHttpResponse;
use Corbpie\NBALive\NBAApiException;
use Corbpie\NBALive\NBABase;
use PHPUnit\Framework\TestCase;

final class NbaHttpClientTest extends TestCase
{
    public function testApiCallUsesInjectedClient(): void
    {
        $mock = new MockNbaHttpClient();
        $mock->register('https://example.test/scoreboard', new NbaHttpResponse(
            url: 'https://example.test/scoreboard',
            statusCode: 200,
            body: '{"scoreboard":{"games":[]}}',
            size: 28,
            connectTime: 0.01,
            ip: '127.0.0.1',
        ));

        $client = new class ($mock) extends NBABase {
            public function __construct(MockNbaHttpClient $httpClient)
            {
                parent::__construct($httpClient);
            }

            public function call(string $url): array
            {
                return $this->ApiCall($url);
            }
        };

        $result = $client->call('https://example.test/scoreboard');

        $this->assertSame([], $result['scoreboard']['games']);
        $this->assertSame(200, $client->response_code);
        $this->assertSame('127.0.0.1', $client->ip);
    }

    public function testApiCallThrowsOnHttpError(): void
    {
        $mock = new MockNbaHttpClient();
        $mock->register('https://example.test/missing', new NbaHttpResponse(
            url: 'https://example.test/missing',
            statusCode: 404,
            body: '{"error":"not found"}',
            size: 21,
            connectTime: 0.01,
            ip: '127.0.0.1',
        ));

        $client = new class ($mock) extends NBABase {
            public function __construct(MockNbaHttpClient $httpClient)
            {
                parent::__construct($httpClient);
            }

            public function call(string $url): array
            {
                return $this->ApiCall($url);
            }
        };

        $this->expectException(NBAApiException::class);
        $this->expectExceptionMessage('HTTP code 404');

        $client->call('https://example.test/missing');
    }
}
