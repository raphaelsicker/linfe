<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Preco extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'cheio',
        'custo',
        'promocional'
    ];
}
