<?php

namespace App\Models;

use App\Enums\PriceType;
use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed precos
 */
class PedidoItem extends Model
{
    use HasFactory;

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

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }

    public function precos(): HasMany
    {
        return $this->hasMany(PedidoItemPreco::class);
    }

    public function precoVenda(): float
    {
        return $this->precos
            ->where('tipo', PriceType::SALE)
            ->first()
            ?->valor ?? 0.00;
    }

    protected static function booted()
    {
        static::created(fn(PedidoItem $pedidoItem) => self::addPrices($pedidoItem));
    }

    private static function addPrices(PedidoItem $pedidoItem)
    {
        PedidoItemPreco::importMany(
            $pedidoItem?->produto?->precos?->toArray() ?? [],
            ['pedido_item_id' => $pedidoItem->id]
        );

        return Pedido::totalize($pedidoItem->pedido);
    }
}
