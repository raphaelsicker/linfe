<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Descrição da Natureza da Operação
 *
 * Class NFeNatOpType
 * @package App\Enums
 */
class NFeNatOpType extends Enum
{
    const SALE = 'VENDA';
    const BUY = 'COMPRA';
    const TRANSFER = 'TRANSFERÊNCIA';
    const DEVOLUTION = 'DEVOLUÇÃO';
    const IMPORT = 'IMPORTAÇÃO';
    const CONSIGNMENT = 'CONSIGNAÇÃO';
    const SHIPPING = 'REMESSA';

    protected array $all = [
        self::SALE => 'Venda',
        self::BUY => 'Compra',
        self::TRANSFER => 'Transferência',
        self::DEVOLUTION => 'Devolução',
        self::IMPORT => 'Importação',
        self::CONSIGNMENT => 'Consignação',
        self::SHIPPING => 'Remessa',
    ];
}
