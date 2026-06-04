<?php

declare(strict_types=1);

namespace Akunbeben\InlineConfirm\HoldToConfirm;

use Closure;

final readonly class HoldToConfirmConfig
{
    public function __construct(
        public int $duration = 1500,
        public ?string $originalView = null,
        public bool | Closure | null $closeDropdown = null,
    ) {}
}
