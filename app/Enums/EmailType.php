<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class EmailType extends Enum
{
    const PERSONAL = 'pessoal';
    const COMMERCIAL = 'comercial';

    protected array $all = [
        self::PERSONAL => 'Pessoal',
        self::COMMERCIAL => 'Comercial'
    ];
}
