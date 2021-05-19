<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class DocumentType extends Enum
{
    const CPF = 'cpf';
    const CNPJ = 'cnpj';
    const RG = 'rg';

    protected array $all = [
        self::CPF => 'CPF',
        self::CNPJ => 'CNPJ',
        self::RG => 'RG'
    ];
}
