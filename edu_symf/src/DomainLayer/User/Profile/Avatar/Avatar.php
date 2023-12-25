<?php

namespace App\DomainLayer\User\Profile\Avatar;

class Avatar
{

    public function __construct(
        private string $pathToFile = ''
    )
    {
    }

    public function getPathToFile(): string
    {
        return $this->pathToFile;
    }
}