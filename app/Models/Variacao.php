<?php


namespace App\Models;


use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Variacao
 * @package App\Models
 * @mixin Builder
 */
class Variacao extends Model
{
    protected $table = 'variacoes';

    protected $fillable = [
        'nome',
        'grade_id',
        'li_id'
    ];
}
