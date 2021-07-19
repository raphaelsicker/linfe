<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Indica operação com Consumidor final
 *
 * Class NFeIndFinalType
 * @package App\Enums
 */
class NFeIndFinalType extends Enum
{
    const NORMAL = 0;
    const FINAL = 1;

    protected array $all = [
        self::NORMAL => 'Normal',
        self::FINAL => 'Consumidor final',
    ];
}
