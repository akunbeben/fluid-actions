<?php

declare(strict_types=1);

namespace Akunbeben\FluidActions\HoldToConfirm;

use Akunbeben\FluidActions\Concerns\ChecksActionEligibility;
use Filament\Actions\Action;

final readonly class HoldToConfirmEligibility
{
    use ChecksActionEligibility;

    public function __construct(
        private HoldToConfirmManager $manager,
    ) {}

    public function isEligible(Action $action): bool
    {
        if (! $this->manager->for($action) instanceof HoldToConfirmConfig) {
            return false;
        }

        return ! $this->hasBlockingBehavior($action);
    }
}
