<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class TipoDeEmail extends Enum
{
    const PESSOAL = 'pessoal';
    const COMERCIAL = 'comercial';

    protected array $all = [
        self::PESSOAL => 'Pessoal',
        self::COMERCIAL => 'Comercial'
    ];
}
