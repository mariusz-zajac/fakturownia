<?php

declare(strict_types=1);

namespace Abb\Fakturownia;

final class Response
{
    private ?array $jsonData = null;

    public function __construct(
        private string $content,
        private int $statusCode,
    ) {
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

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
