<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResourceFailed extends JsonResource
{
    public int $statusCode;
    public ?string $message;

    public function __construct($resource = null, ?string $message = null, int $statusCode = 500)
    {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->message = $message ?? 'Request successful';
        $this->statusCode = $statusCode;
    }

    public function toArray(Request $request): array
    {
        return [
            'message' => $this->message,
            'errors' => $this->resource ?? null,
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->statusCode);
    }
}
