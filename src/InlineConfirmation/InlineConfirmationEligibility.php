<?php

namespace Akunbeben\InlineConfirm\InlineConfirmation;

use Closure;
use Filament\Actions\Action;

final readonly class InlineConfirmationEligibility
{
    public function __construct(
        private InlineConfirmationManager $manager,
    ) {}

    public function isEligible(Action $action): bool
    {
        if ($this->manager->for($action) === null) {
            return false;
        }

        if (! $action->isConfirmationRequired()) {
            return false;
        }

        if ($action->getGroup() !== null) {
            return false;
        }

        if ($this->hasSchema($action)) {
            return false;
        }

        if ($action->hasModalContent() || $action->hasModalContentFooter()) {
            return false;
        }

        if (filled($action->getUrl()) || $action->shouldPostToUrl() || $action->canSubmitForm()) {
            return false;
        }

        return true;
    }

    private function hasSchema(Action $action): bool
    {
        return (bool) Closure::bind(
            fn (): bool => $this->schema !== null,
            $action,
            $action,
        )();
    }
}
