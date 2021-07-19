<?php


namespace App\Enums;


use App\Enums\Base\Enum;

/**
 * Unidade de comercialização do produto
 *
 * Class NFeOpType
 * @package App\Enums
 */
class NFeProductUnityType extends Enum
{
    const UN = 'un';
    const M = 'm';
    const L = 'l';
    const KG = 'kg';

    protected array $all = [
        self::UN => 'Unidade',
        self::M => 'Metro',
        self::L => 'Litro',
        self::KG => 'Quilograma',
    ];
}
