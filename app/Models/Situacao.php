<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Situacao
 * @package App\Models
 * @mixin Builder
 */
class Situacao extends Model
{
    protected $table = 'situacoes';

    protected $fillable = [
        'codigo',
        'nome',
        'li_id',
    ];
}
