<?php

namespace Abb\Fakturownia;

/**
 * Class FakturowniaResponse
 */
class FakturowniaResponse
{

    const STATUS_OK        = 'OK';
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
    public function __construct($code, $data)
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
            return self::STATUS_OK;
        }

        if ($code === 404) {
            return self::STATUS_NOT_FOUND;
        }

        return self::STATUS_ERROR;
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
