<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Código do Modelo do Documento Fiscal
 *
 * Class NFeModType
 * @package App\Enums
 */
class NFeModType extends Enum
{
    const NFE = '55';
    const NFCE = '65';

    protected array $all = [
        self::NFE => 'Nota Fiscal Eletrônica',
        self::NFCE => 'Nota Fiscal de Consumidor Eletrônica',
    ];
}
