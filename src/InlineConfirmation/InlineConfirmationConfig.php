<?php

declare(strict_types=1);

namespace Akunbeben\InlineConfirm\InlineConfirmation;

final readonly class InlineConfirmationConfig
{
    public function __construct(
        public int $timeout = 3000,
        public ?string $originalView = null,
    ) {}
}
