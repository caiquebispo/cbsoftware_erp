<?php

namespace App\Enums;

enum Flag: string
{
    case SIM = 'S';
    case NAO = 'N';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
