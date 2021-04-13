<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Pessoa
{
    use HasFactory;

    protected $attributes = [
        'classe' => self::class
    ];
}
