<?php

namespace App\Factory;

class EnumFactory
{
    public static function getName(string $enumClass, mixed $value): ?string
    {
        if (!enum_exists($enumClass)) {
            return null;
        }

        foreach ($enumClass::cases() as $case) {
            if (property_exists($case, 'value') && $case->value === $value) {
                return $case->name;
            }
        }

        return null;
    }
    public static function getValue(string $enumClass, string $name = null): mixed
    {
        if (!enum_exists($enumClass)) {
            return null;
        }

        foreach ($enumClass::cases() as $case) {
            if ($case->name === $name) {
                return $case->value ?? null;
            }
        }

        return null;
    }


}
