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
    public function getCode();

    /**
     * Get response data
     *
     * @return array
     */
    public function getData();

    /**
     * Get response status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Checks if the response has success status
     *
     * @return bool
     */
    public function isSuccess();

    /**
     * Checks if the response has 'not found' status
     *
     * @return bool
     */
    public function isNotFound();

    /**
     * Checks if the response has error status
     *
     * @return bool
     */
    public function isError();

    /**
     * Convert response to array
     *
     * @return array
     */
    public function toArray();
}
