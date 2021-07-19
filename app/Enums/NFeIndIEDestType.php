<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Tipo de Operação
 *
 * Nota 1: No caso de NFC-e informar indIEDest=9 e não informar a tag IE do destinatário;
 * Nota 2: No caso de operação com o Exterior informar indIEDest=9 e não informar a tag IE do destinatário;
 * Nota 3: No caso de Contribuinte Isento de Inscrição (indIEDest=2), não informar a tag IE do destinatário.
 *
 * Class NFeOpType
 * @package App\Enums
 */
class NFeIndIEDestType extends Enum
{
    const CONTRIBUTOR = 0;
    const EXEMPT = 1;
    const NON_CONTRIBUTOR = 9;

    protected array $all = [
        self::CONTRIBUTOR => 'Contribuinte ICMS (informar a IE do destinatário)',
        self::EXEMPT => 'Contribuinte isento de Inscrição no cadastro de Contribuintes do ICMS',
        self::NON_CONTRIBUTOR => 'Não Contribuinte, que pode ou não possuir Inscrição Estadual no Cadastro de Contribuintes do ICMS',
    ];
}
