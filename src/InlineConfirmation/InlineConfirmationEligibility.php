<?php

declare(strict_types=1);

namespace Akunbeben\FluidActions\InlineConfirmation;

use Akunbeben\FluidActions\Concerns\ChecksActionEligibility;
use Filament\Actions\Action;

final readonly class InlineConfirmationEligibility
{
    use ChecksActionEligibility;

    public function __construct(
        private InlineConfirmationManager $manager,
    ) {}

    public function isEligible(Action $action): bool
    {
        if (! $this->manager->for($action) instanceof InlineConfirmationConfig) {
            return false;
        }

        if (! $action->isConfirmationRequired()) {
            return false;
        }

        return ! $this->hasBlockingBehavior($action);
    }
}
