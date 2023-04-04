<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class BadRequestException extends \JsonException
{

    public function __construct(string $message, int $statusCode = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message, $statusCode);
    }

    public function toJson(): string
    {
        return $this->getMessage();
    }

    public function toArray(): array
    {
        return json_decode($this->getMessage(), true);
    }
}
