<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Processo de emissão da NF-e
 *
 * Class NFeProcEmiType
 * @package App\Enums
 */
class NFeProcEmiType extends Enum
{
    const OWN_APP = 0;
    const SINGLE_BY_FISCO = 1;
    const SINGLE_BY_FISCO_SITE = 2;
    const SINGLE_BY_FISCO_APP = 3;

    protected array $all = [
        self::OWN_APP => 'Emissão de NF-e com aplicativo do contribuinte',
        self::SINGLE_BY_FISCO => 'Emissão de NF-e avulsa pelo Fisco',
        self::SINGLE_BY_FISCO_SITE => 'Emissão de NF-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco',
        self::SINGLE_BY_FISCO_APP => 'Emissão NF-e pelo contribuinte com aplicativo fornecido pelo Fisco',
    ];
}
