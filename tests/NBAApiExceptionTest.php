<?php

namespace Corbpie\NBALive\Tests;

use Corbpie\NBALive\NBAApiException;
use PHPUnit\Framework\TestCase;

/**
 * Tests for NBAApiException class.
 */
class NBAApiExceptionTest extends TestCase
{
    public function testExceptionMessage(): void
    {
        $exception = new NBAApiException('API request failed', 404);

        $this->assertEquals('API request failed', $exception->getMessage());
    }

    public function testHttpCode(): void
    {
        $exception = new NBAApiException('API request failed', 500);

        $this->assertEquals(500, $exception->getHttpCode());
        $this->assertEquals(500, $exception->getCode());
    }

    public function testResponseBody(): void
    {
        $responseBody = ['error' => 'Not found', 'code' => 404];
        $exception = new NBAApiException('API request failed', 404, $responseBody);

        $this->assertEquals($responseBody, $exception->getResponseBody());
    }

    public function testNullResponseBody(): void
    {
        $exception = new NBAApiException('API request failed', 500);

        $this->assertNull($exception->getResponseBody());
    }

    public function testPreviousException(): void
    {
        $previous = new \Exception('Previous error');
        $exception = new NBAApiException('API request failed', 500, null, $previous);

        $this->assertSame($previous, $exception->getPrevious());
    }
}
