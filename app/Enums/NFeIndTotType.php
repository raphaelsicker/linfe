<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Tipo de Operação
 *
 * Class NFeIndTotType
 * @package App\Enums
 */
class NFeIndTotType extends Enum
{
    const NOT = 0;
    const YES = 1;

    protected array $all = [
        self::NOT => 'Valor do item (vProd) não compõe o valor total da NF-e',
        self::YES => 'Valor do item (vProd) compõe o valor total da NF-e (vProd) (v2.0)',
    ];
}
