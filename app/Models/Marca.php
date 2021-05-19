<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Marca
 * @package App\Models
 * @mixin Builder
 */
class Marca extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'apelido',
        'descricao',
        'li_id'
    ];
}
