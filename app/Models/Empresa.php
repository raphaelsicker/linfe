<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Empresa
 * @package App\Models
 * @mixin Builder
 */
class Empresa extends Pessoa
{
    use HasFactory;

    protected $attributes = [
        'classe' => self::class
    ];
}
