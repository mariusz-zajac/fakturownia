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
        // check pattern: token_hash/subdomain
        $isValid = is_string($token) && 1 === preg_match('~^[^/]+/[^/]+$~', $token);

        if (!$isValid) {
            throw new InvalidTokenException(
                'Invalid API token. Only tokens with prefix are supported. You can generate it in fakturownia.pl service.'
            );
        }
    }
}
