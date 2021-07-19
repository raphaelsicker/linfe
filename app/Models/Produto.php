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
 *
 * @property int id
 * @property string nome
 * @property string apelido
 * @property string descricao_completa
 * @property boolean ativo
 * @property boolean bloqueado
 * @property boolean removido
 * @property boolean destaque
 * @property boolean usado
 * @property int marca_id
 * @property int pai_id
 * @property float altura
 * @property float largura
 * @property float profundidade
 * @property int peso
 * @property string ncm
 * @property string sku
 * @property int li_id
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
