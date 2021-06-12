<?php

namespace App\Models;

use App\Models\Base\Model;

class PedidoEntrega extends Model
{
    protected $fillable = [
        'pedido_id',
        'endereco_id',
    ];
}
