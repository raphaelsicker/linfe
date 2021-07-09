<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Produto
 * @package App\Models
 * @mixin Builder
 */
class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'apelido',
        'descricao_completa',
        'ativo',
        'bloqueado',
        'removido',
        'destaque',
        'usado',
        'marca_id',
        'pai_id',
        'altura',
        'largura',
        'peso',
        'profundidade',
        'ncm',
        'sku',
        'li_id'
    ];

    public function precos(): HasMany
    {
        return $this->hasMany(ProdutoPreco::class);
    }
}
