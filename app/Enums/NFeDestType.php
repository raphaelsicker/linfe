<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Identificador de local de destino da operação
 *
 * Class NFeDestType
 * @package App\Enums
 */
class NFeDestType extends Enum
{
    const INTERNAL = 1;
    const INTERSTATE = 2;
    const EXTERIOR = 3;

    protected array $all = [
        self::INTERNAL => 'Operação interna',
        self::INTERSTATE => 'Operação interestadual',
        self::EXTERIOR => 'Operação com exterior',
    ];
}
