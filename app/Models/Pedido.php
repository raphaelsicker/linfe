<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Pedido
 * @property float peso_real
 * @property float valor_subtotal
 * @property float valor_envio
 * @property float valor_desconto
 * @property float valor_total
 * @package App\Models
 */
class Pedido extends Model
{
    use HasFactory;

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

    public static function totalize(Pedido $pedido): Pedido
    {
        $pedido->valor_subtotal = 0;
        $pedido->peso_real = 0;

        foreach ($pedido->itens ?? [] as $item) {
            $pedido->peso_real += $item->produto->peso * $item->quantidade;
            $pedido->valor_subtotal += $item->precoVenda() * $item->quantidade;
        }

        $pedido->valor_total = $pedido->valor_subtotal + $pedido->valor_envio - $pedido->valor_desconto;
        $pedido->save();

        return $pedido;
    }
}
