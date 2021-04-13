<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Estado
 * @package App\Models
 * @mixin Builder
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
