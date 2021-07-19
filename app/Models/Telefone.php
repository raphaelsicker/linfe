<?php

namespace App\Models;


use App\Enums\PhoneType;
use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Telefone
 * @package App\Models
 * @mixin Builder
 *
 * @property int id
 * @property int pessoa_id
 * @property int tipo
 * @property string numero
 */
class Telefone extends Model
{
    protected $fillable = [
        'pessoa_id',
        'tipo',
        'numero'
    ];

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class);
    }

    /**
     * Escopo para retornar apenas os telefones celulares
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeCelular(Builder $query): Builder
    {
        return $query->where('tipo', PhoneType::CELL);
    }

    /**
     * Escopo para retornar apenas os telefones fixos
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeFixo(Builder $query): Builder
    {
        return $query->where('tipo', PhoneType::LANDLINE);
    }

    /**
     * Escopo para retornar apenas os telefones comerciais
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeComercial(Builder $query): Builder
    {
        return $query->where('tipo', PhoneType::COMMERCIAL);
    }
}
