<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Pedido
 * @package App\Models
 */
class Pedido extends Model
{
    protected $fillable = [
        'pessoa_id',
        'situacao_id',
        'cliente_obs',
        'cupom_desconto',
        'peso_real',
        'valor_desconto',
        'valor_envio',
        'valor_subtotal',
        'valor_total',
        'li_id'
    ];

    public function itens(): HasMany
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function entrega(): HasOne
    {
        return $this->hasOne(PedidoEntrega::class);
    }

    public function pagamentos(): HasMany
    {
        return $this->hasMany(PedidoPagamento::class);
    }
}
