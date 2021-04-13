<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class TipoDeTelefone extends Enum
{
    const FIXO = 'fixo';
    const CELULAR = 'celular';
    const COMERCIAL = 'comercial';

    protected array $all = [
        self::FIXO => 'Fixo',
        self::CELULAR => 'Celular',
        self::COMERCIAL => 'Comercial'
    ];
}
