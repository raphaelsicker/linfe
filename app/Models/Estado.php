<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Estado
 * @package App\Models
 * @mixin Builder
 *
 * @property int id
 * @property string nome
 * @property int ibge
 * @property string uf
 *
 * @property Collection cidades
 */
class Estado extends Model
{
    protected $fillable = [
        'id',
        'nome',
        'ibge',
        'uf',
    ];

    public function cidades(): HasMany
    {
        return $this->hasMany(Cidade::class);
    }
}
