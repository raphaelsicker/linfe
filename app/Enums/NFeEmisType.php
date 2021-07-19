<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Tipo de Emissão da NF-e
 *
 * Class NFeEmisType
 * @package App\Enums
 */
class NFeEmisType extends Enum
{
    const NORMAL = 1;
    const FSIA = 2;
    const SCAN = 3;
    const DPEC = 4;
    const FSDA = 5;
    const SVCAN = 6;
    const SVCRS = 7;

    protected array $all = [
        self::NORMAL => 'Emissão normal (não em contingência)',
        self::FSIA => 'Contingência FS-IA, com impressão do DANFE em formulário de segurança',
        self::SCAN => 'Contingência SCAN (Sistema de Contingência do Ambiente Nacional)',
        self::DPEC => 'Contingência DPEC (Declaração Prévia da Emissão em Contingência)',
        self::FSDA => 'Contingência FS-DA, com impressão do DANFE em formulário de segurança',
        self::SVCAN => 'Contingência SVC-AN (SEFAZ Virtual de Contingência do AN)',
        self::SVCRS => 'Contingência SVC-RS (SEFAZ Virtual de Contingência do RS)',
    ];
}
