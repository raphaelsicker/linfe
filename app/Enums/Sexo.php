<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class Sexo extends Enum
{
    const MASCULINO = 'm';
    const FEMININO = 'f';
    const OUTROS = 'o';

    protected array $all = [
        self::MASCULINO => 'Masculino',
        self::FEMININO => 'Feminino',
        self::OUTROS => 'Outros'
    ];
}
