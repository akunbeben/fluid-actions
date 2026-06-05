<?php

declare(strict_types=1);

namespace Akunbeben\FluidActions\InlineConfirmation;

use Closure;

final readonly class InlineConfirmationConfig
{
    public function __construct(
        public int $timeout = 3000,
        public ?string $originalView = null,
        public bool | Closure | null $closeDropdown = null,
    ) {}
}
