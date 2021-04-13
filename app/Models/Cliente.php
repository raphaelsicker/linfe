<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Cliente
 * @package App\Models
 * @mixin Builder
 */
class Cliente extends Pessoa
{
    use HasFactory;

    protected $attributes = [
        'classe' => self::class
    ];
}
