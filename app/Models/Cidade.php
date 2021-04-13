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
}
