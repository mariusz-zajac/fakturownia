<?php

namespace Abb\Fakturownia;

/**
 * Class FakturowniaResponse
 */
class FakturowniaResponse
{

    const STATUS_SUCCESS   = 'SUCCESS';
    const STATUS_NOT_FOUND = 'NOT_FOUND';
    const STATUS_ERROR     = 'ERROR';

    /**
     * @var integer
     */
    private $code;

    /**
     * @var array
     */
    private $data;

    /**
     * Constructor
     *
     * @param integer $code
     * @param array   $data
     */
    public function __construct($code, array $data)
    {
        $this->code = $code;
        $this->data = $data;
    }

    /**
     * Get response code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get response data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get response status
     *
     * @return string
     */
    public function getStatus()
    {
        $code = $this->code;

        if (200 <= $code && $code < 300) {
            return self::STATUS_SUCCESS;
        }

        if ($code === 404) {
            return self::STATUS_NOT_FOUND;
        }

        return self::STATUS_ERROR;
    }

    /**
     * Checks if the response has success status
     *
     * @return bool
     */
    public function isSuccess()
    {
        return self::STATUS_SUCCESS === $this->getStatus();
    }

    /**
     * Checks if the response has 'not found' status
     *
     * @return bool
     */
    public function isNotFound()
    {
        return self::STATUS_NOT_FOUND === $this->getStatus();
    }

    /**
     * Checks if the response has error status
     *
     * @return bool
     */
    public function isError()
    {
        return self::STATUS_ERROR === $this->getStatus();
    }

    /**
     * Convert response to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'code' => $this->getCode(),
            'status' => $this->getStatus(),
            'data' => $this->getData(),
        ];
    }
}
