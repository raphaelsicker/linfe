<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class Country extends Enum
{
    const BRASIL = '1058';

    protected array $all = [
        self::BRASIL => 'Brasil',
    ];
}
