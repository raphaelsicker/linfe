<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PedidoPagamento extends Model
{
    protected $fillable = [
        'tipo',
        'forma_id',
        'pedido_id',
        'valor',
        'valor_pago',
        'numero_de_parcelas',
        'valor_das_parcelas',
        'li_id',
    ];

    public function forma()
    {
        return $this->belongsTo(FormaDePagamento::class, 'forma_id');
    }
}
