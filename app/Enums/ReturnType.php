<?php


namespace App\Enums;


use App\Enums\Base\Enum;

class ReturnType extends Enum
{
    const ARRAY = 'array';
    const INT = 'int';
    const OBJECT = 'object';
    const STRING = 'string';

    protected array $all = [
        self::ARRAY => 'Array',
        self::INT => 'Int',
        self::OBJECT => 'Object',
        self::STRING => 'String',
    ];
}
