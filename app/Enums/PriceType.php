<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class PriceType extends Enum
{
    const COST = 'cost';
    const FULL = 'full';
    const PROMOTIONAL = 'promotional';
    const SALE = 'sale';

    protected array $all = [
        self::COST => 'Preço Completo',
        self::FULL => 'Preço Completo',
        self::PROMOTIONAL => 'Preço Promocional',
        self::SALE => 'Preço de Venda'
    ];
}
