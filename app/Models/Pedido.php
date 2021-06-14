<?php

namespace App\Models;

use App\Models\Base\Model;

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
}
