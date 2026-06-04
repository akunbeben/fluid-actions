<?php

declare(strict_types=1);

namespace Akunbeben\InlineConfirm\Concerns;

use Closure;
use Filament\Actions\Action;

trait ChecksActionEligibility
{
    protected function hasSchema(Action $action): bool
    {
        return (bool) Closure::bind(
            fn (): bool => $this->schema !== null,
            $action,
            $action,
        )();
    }

    protected function hasBlockingBehavior(Action $action): bool
    {
        if ($this->hasSchema($action)) {
            return true;
        }

        if ($action->hasModalContent() || $action->hasModalContentFooter()) {
            return true;
        }

        if (filled($action->getUrl())) {
            return true;
        }

        if ($action->shouldPostToUrl()) {
            return true;
        }

        return $action->canSubmitForm();
    }
}
