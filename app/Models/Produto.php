<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Produto
 * @package App\Models
 * @mixin Builder
 */
class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        "nome",
        "apelido",
        "descricao_completa",

        "ativo",
        "bloqueado",
        "removido",

        "destaque",
        "usado",
        "marca_id",
        "pai_id",

        "altura",
        "largura",
        "peso",
        "profundidade",

        "ncm",
        "gtin",
        "mpn",
        "sku",
        "tipo",
    ];
}
