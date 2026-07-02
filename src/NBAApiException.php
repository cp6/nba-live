<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

/**
 * Exception thrown when NBA API requests fail.
 */
final class NBAApiException extends \Exception
{
    public function __construct(
        string $message,
        private readonly int $httpCode = 0,
        private readonly ?array $responseBody = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $httpCode, $previous);
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getResponseBody(): ?array
    {
        return $this->responseBody;
    }
}
