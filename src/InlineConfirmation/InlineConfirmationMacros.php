<?php

declare(strict_types=1);

namespace Akunbeben\InlineConfirm\InlineConfirmation;

use Closure;
use Filament\Actions\Action;

final class InlineConfirmationMacros
{
    public static function inlineConfirmation(): Closure
    {
        return self::actionMacro(fn (int $timeout = 3000, bool | Closure | null $closeDropdown = null): Action => app(InlineConfirmationManager::class)->enable($this, $timeout, $closeDropdown));
    }

    public static function isInlineConfirmationEligible(): Closure
    {
        return self::actionMacro(fn (): bool => app(InlineConfirmationEligibility::class)->isEligible($this));
    }

    /**
     * @param-closure-this Action $macro
     */
    private static function actionMacro(Closure $macro): Closure
    {
        return $macro;
    }
}
