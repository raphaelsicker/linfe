<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class NFeAmbType extends Enum
{
    const PROD = 1;
    const HOMOLOG = 2;

    protected array $all = [
        self::PROD => 'Produção',
        self::HOMOLOG => 'Homologação',
    ];
}
