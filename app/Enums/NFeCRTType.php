<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Código de Regime Tributário
 *
 * Class NFeCRTType
 * @package App\Enums
 */
class NFeCRTType extends Enum
{
    const SIMPLE = 1;
    const SIMPLE_EXCEEDED = 2;
    const NORMAL = 3;

    protected array $all = [
        self::SIMPLE => 'Simples Nacional',
        self::SIMPLE_EXCEEDED => 'Simples Nacional, excesso sublimite de receita bruta',
        self::NORMAL => 'Regime Normal',
    ];
}
