<?php

namespace App\View\EmailSchema\DTO;

readonly class GetMessageDTO
{
    public function __construct(
        public ?string $html = '',
        public ?string $text = ''
    )
    {
    }
}