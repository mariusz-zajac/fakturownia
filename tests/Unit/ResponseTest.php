<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Tests\Unit;

use Abb\Fakturownia\Response;

final class ResponseTest extends AbstractTestCase
{
    public function testToArrayReturnsEmptyArrayForEmptyBody(): void
    {
        $response = new Response(204, [], '');

        $this->assertSame([], $response->toArray());
    }
}
