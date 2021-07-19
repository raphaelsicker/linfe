<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Finalidade de emissão da NF-e
 *
 * Class NFeFinType
 * @package App\Enums
 */
class NFeFinType extends Enum
{
    const NORMAL = 1;
    const COMPLEMENTARY = 2;
    const ADJUSTMENT = 3;
    const DEVOLUTION = 4;

    protected array $all = [
        self::NORMAL => 'Normal',
        self::COMPLEMENTARY => 'Complementar',
        self::ADJUSTMENT => 'Ajuste',
        self::DEVOLUTION => 'Devolução',
    ];
}
