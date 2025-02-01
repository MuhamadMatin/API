<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResourceFailed extends Response
{
    public int $statusCode;
    public ?string $message;

    public function __construct($errors = null, ?string $message = null, int $statusCode = 400)
    {
        parent::__construct([
            'message' => $message ?? 'Something wrong',
            'errors' => $errors,
        ], $statusCode);
    }
}
