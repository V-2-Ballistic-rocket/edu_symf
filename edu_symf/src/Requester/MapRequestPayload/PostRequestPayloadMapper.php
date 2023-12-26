<?php

namespace App\Requester\MapRequestPayload;

use App\Requester\Controller\DTO\UserRegistrationRequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsTargetedValueResolver;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

#[AsTargetedValueResolver('user_registration_request_dto')]
class PostRequestPayloadMapper implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if(!$argument->getType()){
            return [];
        }
        return [new UserRegistrationRequestDTO(
            $request->get('login') ?? null,
            $request->get('password') ?? null,
            $request->get('email') ?? null,
            $request->get('phone_number') ?? null,
            $request->get('first_name') ?? null,
            $request->get('last_name') ?? null,
            $request->get('age') ?? null,
            $request->get('path_to_avatar') ?? null,
            $request->get('country') ?? null,
            $request->get('city') ?? null,
            $request->get('street') ?? null,
            $request->get('house_number') ?? null
        )];
    }
}