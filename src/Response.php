<?php

declare(strict_types=1);

namespace Abb\Fakturownia;

class Response
{
    protected ?array $jsonData = null;

    /**
     * @param string[][] $headers
     */
    public function __construct(
        protected readonly string $content,
        protected readonly array $headers,
        protected readonly int $statusCode,
    ) {
    }

    /**
     * Return the response body as a string or JSON array if content type is JSON
     *
     * @throws \JsonException When the response body cannot be decoded to an array
     */
    public function getContent(): array|string
    {
        if (null !== $this->jsonData) {
            return $this->jsonData;
        }

        if ($this->isJson()) {
            return $this->jsonData = (array) json_decode($this->content, true, 512, JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING);
        }

        return $this->content;
    }

    /**
     * Gets the HTTP headers of the response
     *
     * @return string[][]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Gets the HTTP status code of the response
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function isJson(): bool
    {
        return str_contains(strtolower($this->headers['content-type'][0] ?? ''), 'application/json');
    }
}
