<?php

namespace App\Traits;

trait Utilities
{
    public static function caseValues(): array
    {
        return array_column(static::cases(), 'value');
    }

    public static function caseNames(): array
    {
        return array_column(static::cases(), 'name');
    }
}
