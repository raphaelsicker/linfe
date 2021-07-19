<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Indicador de presença do comprador no estabelecimento comercial no momento da operação
 *
 * Class NFeIndPresType
 * @package App\Enums
 */
class NFeIndPresType extends Enum
{
    const NOT_APLY = 0;
    const PRESENTIAL = 1;
    const INTERNET = 2;
    const CALL_CENTER = 3;
    const NFCE_IN_HOME = 4;
    const OTHERS = 9;

    protected array $all = [
        self::NOT_APLY => 'Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste)',
        self::PRESENTIAL => 'Operação presencial',
        self::INTERNET => 'Operação não presencial, pela Internet',
        self::CALL_CENTER => 'Operação não presencial, Teleatendimento',
        self::NFCE_IN_HOME => 'NFC-e em operação com entrega a domicílio',
        self::OTHERS => 'Operação não presencial, outros.',
    ];
}
