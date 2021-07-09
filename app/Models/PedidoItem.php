<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PedidoItem extends Model
{
    protected $table = 'pedido_itens';

    protected $fillable = [
        'pedido_id',
        'produto_id',
        'nome',
        'quantidade',
        'ncm',
        'altura',
        'largura',
        'profundidade',
        'peso',
        'li_id'
    ];

    public function precos(): HasMany
    {
        return $this->hasMany(PedidoItemPreco::class);
    }
}
