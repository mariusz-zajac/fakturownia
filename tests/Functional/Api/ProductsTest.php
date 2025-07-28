<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Functional\Api;

use Abb\Fakturownia\Config;
use Abb\Fakturownia\Exception\ApiException;
use Abb\Fakturownia\Fakturownia;
use Abb\Fakturownia\Tests\Functional\AbstractTestCase;

final class ProductsTest extends AbstractTestCase
{
    public function testCreateProduct(): int
    {
        $name = 'Test Product';
        $description = sprintf('[%s] Created at %s', Fakturownia::USER_AGENT, (new \DateTimeImmutable())->format('Y-m-d H:i:s'));
        $response = $this->fakturownia->products()->create([
            'name' => $name,
            'description' => $description,
        ]);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertSame($name, $response['name']);
        $this->assertSame($description, $response['description']);

        return $response['id'];
    }

    /**
     * @depends testCreateProduct
     */
    public function testGetProduct(int $productId): int
    {
        $response = $this->fakturownia->products()->getOne($productId);

        $this->assertIsArray($response);
        $this->assertSame($productId, $response['id']);
        $this->assertSame('Test Product', $response['name']);

        return $productId;
    }

    /**
     * @depends testGetProduct
     */
    public function testUpdateProduct(int $productId): int
    {
        $description = sprintf('[%s] Updated at %s', Fakturownia::USER_AGENT, (new \DateTimeImmutable())->format('Y-m-d H:i:s'));
        $response = $this->fakturownia->products()->update($productId, [
            'description' => $description,
        ]);

        $this->assertIsArray($response);
        $this->assertSame($productId, $response['id']);
        $this->assertSame($description, $response['description']);

        return $productId;
    }

    /**
     * @depends testUpdateProduct
     */
    public function testDeleteProduct(int $productId): int
    {
        $response = $this->fakturownia->products()->delete($productId);

        $this->assertIsArray($response);
        $this->assertSame('ok', $response[0]);

        return $productId;
    }

    /**
     * @depends testDeleteProduct
     */
    public function testProductNotFound(int $productId): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Not Found');
        $this->expectExceptionCode(404);

        $this->fakturownia->products()->getOne($productId);
    }

    public function testAccessDenied(): void
    {
        $config = new Config('foo', 'bar');
        $fakturownia = new Fakturownia($config);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('You must be logged in to gain access to the site');
        $this->expectExceptionCode(401);

        $fakturownia->products()->getOne(1);
    }
}
