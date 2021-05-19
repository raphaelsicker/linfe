<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class PersonType extends Enum
{
    const PF = 'pf';
    const PJ = 'pj';

    protected array $all = [
        self::PF => 'Pessoa Física',
        self::PJ => 'Pessoa Jurídica'
    ];
}
