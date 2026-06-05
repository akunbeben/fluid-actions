<?php

declare(strict_types=1);

namespace Akunbeben\FluidActions\HoldToConfirm;

use Closure;
use Filament\Actions\Action;

final class HoldToConfirmMacros
{
    public static function holdToConfirm(): Closure
    {
        return self::actionMacro(fn (int $duration = 1500, bool | Closure | null $closeDropdown = null): Action => app(HoldToConfirmManager::class)->enable($this, $duration, $closeDropdown));
    }

    public static function isHoldToConfirmEligible(): Closure
    {
        return self::actionMacro(fn (): bool => app(HoldToConfirmEligibility::class)->isEligible($this));
    }

    /**
     * @param-closure-this Action $macro
     */
    private static function actionMacro(Closure $macro): Closure
    {
        return $macro;
    }
}
