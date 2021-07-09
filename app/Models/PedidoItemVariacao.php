<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PedidoItemVariacao
 * @package App\Models
 * @mixin Builder
 */
class PedidoItemVariacao extends Model
{
    protected $table = 'pedido_item_variacoes';

    protected $fillable = [
        'variacao_id',
        'pedido_item_id',
    ];
}
