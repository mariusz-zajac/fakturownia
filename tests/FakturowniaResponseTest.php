<?php

namespace Abb\Fakturownia\Tests;

use Abb\Fakturownia\FakturowniaResponse;
use PHPUnit\Framework\TestCase;

class FakturowniaResponseTest extends TestCase
{

    /**
     * @dataProvider providerResponseData
     */
    public function testResponse($code, $data, $status, $isSuccess, $isNotFound, $isError, $array)
    {
        $response = new FakturowniaResponse($code, $data);

        self::assertEquals($code, $response->getCode());
        self::assertEquals($data, $response->getData());
        self::assertEquals($status, $response->getStatus());
        self::assertSame($isSuccess, $response->isSuccess());
        self::assertSame($isNotFound, $response->isNotFound());
        self::assertSame($isError, $response->isError());
        self::assertEquals($array, $response->toArray());
    }

    /**
     * @return array
     */
    public function providerResponseData()
    {
        return [
            [
                199, // code
                ['message' => 'Test'], // data
                'ERROR', // status
                false, // isSuccess
                false, // isNotFound
                true, // isError
                ['code' => 199, 'status' => 'ERROR', 'data' => ['message' => 'Test']], // toArray
            ],
            [
                200,
                ['message' => 'Test'],
                'SUCCESS',
                true,
                false,
                false,
                ['code' => 200, 'status' => 'SUCCESS', 'data' => ['message' => 'Test']],
            ],
            [
                201,
                ['message' => 'Test'],
                'SUCCESS',
                true,
                false,
                false,
                ['code' => 201, 'status' => 'SUCCESS', 'data' => ['message' => 'Test']],
            ],
            [
                299,
                ['message' => 'Test'],
                'SUCCESS',
                true,
                false,
                false,
                ['code' => 299, 'status' => 'SUCCESS', 'data' => ['message' => 'Test']],
            ],
            [
                300,
                ['message' => 'Test'],
                'ERROR',
                false,
                false,
                true,
                ['code' => 300, 'status' => 'ERROR', 'data' => ['message' => 'Test']],
            ],
            [
                403,
                ['message' => 'Test'],
                'ERROR',
                false,
                false,
                true,
                ['code' => 403, 'status' => 'ERROR', 'data' => ['message' => 'Test']],
            ],
            [
                404,
                ['message' => 'Test'],
                'NOT_FOUND',
                false,
                true,
                false,
                ['code' => 404, 'status' => 'NOT_FOUND', 'data' => ['message' => 'Test']],
            ],
            [
                405,
                ['message' => 'Test'],
                'ERROR',
                false,
                false,
                true,
                ['code' => 405, 'status' => 'ERROR', 'data' => ['message' => 'Test']],
            ],
            [
                500,
                ['message' => 'Test'],
                'ERROR',
                false,
                false,
                true,
                ['code' => 500, 'status' => 'ERROR', 'data' => ['message' => 'Test']],
            ],
        ];
    }
}
