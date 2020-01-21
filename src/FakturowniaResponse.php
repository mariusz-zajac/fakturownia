<?php

namespace Abb\Fakturownia;

/**
 * Response object returning by Fakturownia client
 */
class FakturowniaResponse implements ResponseInterface
{

    const STATUS_SUCCESS   = 'SUCCESS';
    const STATUS_NOT_FOUND = 'NOT_FOUND';
    const STATUS_ERROR     = 'ERROR';

    /**
     * @var int
     */
    protected $code;

    /**
     * @var array
     */
    protected $data;

    /**
     * Constructor
     *
     * @param int   $code Response code
     * @param array $data Response data
     */
    public function __construct($code, array $data)
    {
        $this->code = $code;
        $this->data = $data;
    }

    /**
     * {@inheritDoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {
        if (200 <= $this->code && $this->code < 300) {
            return self::STATUS_SUCCESS;
        }

        if ($this->code === 404) {
            return self::STATUS_NOT_FOUND;
        }

        return self::STATUS_ERROR;
    }

    /**
     * {@inheritDoc}
     */
    public function isSuccess()
    {
        return self::STATUS_SUCCESS === $this->getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function isNotFound()
    {
        return self::STATUS_NOT_FOUND === $this->getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function isError()
    {
        return self::STATUS_ERROR === $this->getStatus();
    }

    /**
     * {@inheritDoc}
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
