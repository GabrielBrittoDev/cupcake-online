<?php

namespace App\Enums;

use BackedEnum;
use Illuminate\Support\Collection;

trait EnumHelperTrait
{
    public static function isValid($value): bool
    {
        return $value !== null && self::tryFrom($value) !== null;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function count(): int
    {
        return count(self::cases());
    }

    /** @return self[] */
    public static function fromMany(array $items): array
    {
        return array_map(
            fn (mixed $value) => self::from($value),
            $items
        );
    }

    public static function collect(): Collection
    {
        return collect(self::cases());
    }

    public static function tryFromName(string $name): ?BackedEnum
    {
        $case = strtoupper($name);

        if (!defined(static::class . '::' . $case)) {
            return null;
        }

        return static::class::{$case};
    }
}
