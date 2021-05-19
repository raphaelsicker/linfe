<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class Gender extends Enum
{
    const MALE = 'm';
    const FEMALE = 'f';
    const OTHERS = 'o';

    protected array $all = [
        self::MALE => 'Masculino',
        self::FEMALE => 'Feminino',
        self::OTHERS => 'Outros'
    ];
}
