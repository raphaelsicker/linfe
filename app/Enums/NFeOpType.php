<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Tipo de Operação
 *
 * Class NFeOpType
 * @package App\Enums
 */
class NFeOpType extends Enum
{
    const INPUT = 0;
    const OUTPUT = 1;

    protected array $all = [
        self::INPUT => 'Entrada',
        self::OUTPUT => 'Saída',
    ];
}
