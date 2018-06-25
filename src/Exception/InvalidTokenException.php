<?php

namespace Abb\Fakturownia\Exception;

class InvalidTokenException extends \InvalidArgumentException
{

    public function __construct()
    {
        parent::__construct('Invalid Fakturownia API token');
    }
}
