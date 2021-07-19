<?php

namespace App\Models;

use App\Helpers\Str;
use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Endereco
 * @package App\Models
 * @mixin Builder
 * @property string pessoa_id
 * @property boolean principal
 * @property string endereco
 * @property string numero
 * @property string complemento
 * @property string bairro
 * @property string cep
 * @property int cidade_id
 * @property string referencia
 * @property Cidade cidade
 */
class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id',
        'principal',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'cidade_id',
        'referencia',
    ];

    public function cidade(): BelongsTo
    {
        return $this->belongsTo(Cidade::class);
    }

    /**
     * Escopo para retornar apenas os telefones principais
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePrincipal(Builder $query): Builder
    {
        return $query->where('principal', true);
    }

    public function completo(): string
    {
        return $this->endereco
            . Str::addPrefix($this->numero, ', ')
            . Str::addPrefix($this->complemento, ' - ')
            . Str::addPrefix($this->bairro, ' - ');
    }
}
