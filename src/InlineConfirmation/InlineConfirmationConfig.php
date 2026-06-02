<?php

namespace Akunbeben\InlineConfirm\InlineConfirmation;

final readonly class InlineConfirmationConfig
{
    public function __construct(
        public ?string $label = null,
        public int $timeout = 3000,
        public string $originalView = 'filament::components.button.index',
    ) {}
}
