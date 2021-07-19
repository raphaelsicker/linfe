<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Formato de Impressão do DANFE
 *
 * Class NFeDANFeType
 * @package App\Enums
 */
class NFeDANFeType extends Enum
{
    const NO_GENERATION = 0;
    const NORMAL_PORTRAIT = 1;
    const NORMAL_LANDSCAPE = 2;
    const SIMPLIFIED = 3;
    const NFCE = 4;
    const NFCE_EMAIL = 5;


    protected array $all = [
        self::NO_GENERATION => 'Sem geração de DANFE',
        self::NORMAL_PORTRAIT => 'DANFE normal, Retrato',
        self::NORMAL_LANDSCAPE => 'DANFE normal, Paisagem',
        self::SIMPLIFIED => 'DANFE Simplificado',
        self::NFCE => 'DANFE NFC-e',
        self::NFCE_EMAIL => 'DANFE NFC-e em mensagem eletrônica',
    ];
}
