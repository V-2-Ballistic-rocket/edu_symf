<?php

namespace App\Requester\MapRequestPayload;

class GetRequestPayloadMapper
{
    public function mapRequestPayload(array $requestPayload): array
    {
        return [
            'id' => $requestPayload['id']
        ];
    }
}