<?php

declare(strict_types=1);

namespace Abb\Fakturownia\Exception;

class ApiException extends \Exception implements ExceptionInterface
{
    private array $details;

    public function __construct(string $message, int $code, array $details = [], ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->details = $details;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}
