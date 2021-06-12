<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ProdutoPreco
 * @package App\Models
 * @mixin Builder
 */
class ProdutoPreco extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'valor',
        'produto_id',
    ];
}
