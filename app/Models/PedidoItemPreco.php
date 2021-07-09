<?php

namespace App\Models;

use App\Enums\PriceType;
use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PedidoItemPreco
 * @package App\Models
 * @mixin Builder
 */
class PedidoItemPreco extends Model
{
    protected $fillable = [
        'tipo',
        'valor',
        'pedido_item_id',
    ];

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeCusto(Builder $query): Builder
    {
        return $query->where('tipo', PriceType::COST);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeVenda(Builder $query): Builder
    {
        return $query->where('tipo', PriceType::SALE);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeCompleto(Builder $query): Builder
    {
        return $query->where('tipo', PriceType::FULL);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePromocional(Builder $query): Builder
    {
        return $query->where('tipo', PriceType::PROMOTIONAL);
    }
}
