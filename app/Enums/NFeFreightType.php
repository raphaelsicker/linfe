<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Modalidade do frete
 *
 * Class NFeFreightType
 * @package App\Enums
 */
class NFeFreightType extends Enum
{
    const PAYEE = 0;
    const PAYER = 1;
    const OTHERS = 2;
    const WITHOUT = 9;

    protected array $all = [
        self::PAYEE => 'Por conta do emitente',
        self::PAYER => 'Por conta do destinatário/remetente',
        self::OTHERS => 'Por conta de terceiros',
        self::WITHOUT => 'Sem frete',
    ];
}
