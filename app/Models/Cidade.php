<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Cidade
 * @package App\Models
 * @mixin Builder
 */
class Cidade extends Model
{
    protected $fillable = [
        'id',
        'nome',
        'ibge',
        'estado_id'
    ];

    protected $with = ['estado'];

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class);
    }

    /**
     * @param Builder $query
     * @param string $nome
     * @return Builder
     */
    public function scopeNome(Builder $query, string $nome)
    {
        return $query->where('nome', $nome);
    }
}
