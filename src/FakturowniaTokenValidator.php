<?php

namespace Abb\Fakturownia;

use Abb\Fakturownia\Exception\InvalidTokenException;

/**
 * Fakturownia API Token Validator
 */
class FakturowniaTokenValidator
{

    /**
     * Validate API token
     *
     * @param mixed $token Token
     *
     * @return void
     *
     * @throws InvalidTokenException If token is not valid
     */
    public function isValidTokenOrFail($token): void
    {
        // check pattern: token_hash/username
        $isValid = is_string($token) && 1 === preg_match('~^[^/]+/[^/]+$~', $token);

        if (!$isValid) {
            throw new InvalidTokenException();
        }
    }
}
