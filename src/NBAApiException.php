<?php

namespace Corbpie\NBALive;

/**
 * Exception thrown when NBA API requests fail.
 */
class NBAApiException extends \Exception
{
    private int $httpCode;
    private ?array $responseBody;

    /**
     * Create a new NBA API exception.
     *
     * @param string $message Error message
     * @param int $httpCode HTTP response code from the API
     * @param array|null $responseBody Decoded response body, if available
     * @param \Throwable|null $previous Previous exception
     */
    public function __construct(
        string $message,
        int $httpCode = 0,
        ?array $responseBody = null,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $httpCode, $previous);
        $this->httpCode = $httpCode;
        $this->responseBody = $responseBody;
    }

    /**
     * Get the HTTP response code from the failed API request.
     *
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * Get the decoded response body from the failed API request.
     *
     * @return array|null
     */
    public function getResponseBody(): ?array
    {
        return $this->responseBody;
    }
}
