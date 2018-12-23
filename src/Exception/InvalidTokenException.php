<?php

namespace Abb\Fakturownia\Exception;

/**
 * Exception class for invalid token
 */
class InvalidTokenException extends \InvalidArgumentException
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('Invalid Fakturownia API token');
    }
}
