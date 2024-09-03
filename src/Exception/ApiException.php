<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Exception;

use Abb\Fakturownia\Api\Response;

class ApiException extends \Exception implements ExceptionInterface
{
    private Response $response;

    public function __construct(string $message, int $code, Response $response, \Throwable $previous)
    {
        parent::__construct($message, $code, $previous);

        $this->response = $response;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
