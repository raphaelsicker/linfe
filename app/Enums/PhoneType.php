<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class PhoneType extends Enum
{
    const LANDLINE = 'fixo';
    const CELL = 'celular';
    const COMMERCIAL = 'comercial';

    protected array $all = [
        self::LANDLINE => 'Fixo',
        self::CELL => 'Celular',
        self::COMMERCIAL => 'Comercial'
    ];
}
