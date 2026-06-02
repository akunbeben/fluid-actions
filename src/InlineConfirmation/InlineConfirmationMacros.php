<?php

namespace Akunbeben\InlineConfirm\InlineConfirmation;

use Closure;
use Filament\Actions\Action;

final class InlineConfirmationMacros
{
    public static function inlineConfirmation(): Closure
    {
        return self::actionMacro(function (?string $label = null, int $timeout = 3000): Action {
            return app(InlineConfirmationManager::class)->enable($this, $label, $timeout);
        });
    }

    public static function isInlineConfirmationEligible(): Closure
    {
        return self::actionMacro(function (): bool {
            return app(InlineConfirmationEligibility::class)->isEligible($this);
        });
    }

    /**
     * @param-closure-this Action $macro
     */
    private static function actionMacro(Closure $macro): Closure
    {
        return $macro;
    }
}
