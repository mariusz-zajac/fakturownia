<?php

namespace Abb\Fakturownia\Tests;

use Abb\Fakturownia\FakturowniaTokenValidator;
use PHPUnit\Framework\TestCase;

class FakturowniaTokenValidatorTest extends TestCase
{

    /**
     * @var FakturowniaTokenValidator
     */
    private $tokenValidator;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->tokenValidator = new FakturowniaTokenValidator();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        unset($this->tokenValidator);
    }

    /**
     * @dataProvider providerValidTokens
     *
     * @param $token
     */
    public function testValidatorForValidToken($token)
    {
        $this->tokenValidator->isValidTokenOrFail($token);
    }

    /**
     * @return array
     */
    public function providerValidTokens()
    {
        return [
            ['token/username'],
            ['12a3rt3der/abc_100'],
            ['ToKeN#123!/uSeR-123'],
        ];
    }

    /**
     * @dataProvider providerInvalidTokens
     *
     * @param $token
     */
    public function testValidatorForInvalidToken($token)
    {
        self::expectException('Abb\Fakturownia\Exception\InvalidTokenException');
        $this->tokenValidator->isValidTokenOrFail($token);
    }

    /**
     * @return array
     */
    public function providerInvalidTokens()
    {
        return [
            [''],
            ['/'],
            ['a'],
            ['username/'],
            ['/username/'],
            ['/token'],
            ['token\username'],
            ['token//username'],
            ['abc/def/123'],
            ['a/b/'],
            ['/a/b'],
            [1],
            [0.5],
            [10.0],
            [[]],
            [['token']],
            [null],
            [true],
            [false],
        ];
    }
}
