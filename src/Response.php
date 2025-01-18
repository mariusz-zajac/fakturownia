<?php

declare(strict_types=1);

namespace Abb\Fakturownia;

final class Response
{
    private int $statusCode;

    private array $headers;

    private string $content;

    private ?array $jsonData = null;

    /**
     * @param string[][] $headers
     */
    public function __construct(int $statusCode, array $headers, string $content)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->content = $content;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string[][]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @throws \JsonException When the response body cannot be decoded to an array
     */
    public function toArray(): array
    {
        if (null !== $this->jsonData) {
            return $this->jsonData;
        }

        return $this->jsonData = (array) json_decode($this->content, true, 512, JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING);
    }
}
