<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transportadora extends Pessoa
{
    use HasFactory;

    protected $attributes = [
        'classe' => self::class
    ];
}
