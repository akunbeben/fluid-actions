<?php

declare(strict_types=1);

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
        if (! $this->manager->for($action) instanceof InlineConfirmationConfig) {
            return false;
        }

        if (! $action->isConfirmationRequired()) {
            return false;
        }

        if ($this->hasSchema($action)) {
            return false;
        }

        if ($action->hasModalContent() || $action->hasModalContentFooter()) {
            return false;
        }

        return ! (filled($action->getUrl()) || $action->shouldPostToUrl() || $action->canSubmitForm());
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
