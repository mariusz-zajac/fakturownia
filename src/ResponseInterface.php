<?php

namespace Abb\Fakturownia;

/**
 * Interface for response object returning by Fakturownia REST client
 */
interface ResponseInterface
{

    /**
     * Get response code
     *
     * @return int
     */
    public function getCode(): int;

    /**
     * Get response data
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Get response status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Checks if the response has success status
     *
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * Checks if the response has 'not found' status
     *
     * @return bool
     */
    public function isNotFound(): bool;

    /**
     * Checks if the response has error status
     *
     * @return bool
     */
    public function isError(): bool;

    /**
     * Convert response to array
     *
     * @return array
     */
    public function toArray(): array;
}
