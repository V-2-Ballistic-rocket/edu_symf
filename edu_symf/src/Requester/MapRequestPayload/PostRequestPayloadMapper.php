<?php

namespace App\Requester\MapRequestPayload;

class PostRequestPayloadMapper
{
    public function mapRequestPayload(array $requestPayload): array
    {
        return [
            'first_name' => $requestPayload['first_name'],
            'last_name' => $requestPayload['last_name'],
            'age' => $requestPayload['age'],
            'email' => $requestPayload['email'],
            'phone_number' => $requestPayload['phone_number'],
        ];
    }
}