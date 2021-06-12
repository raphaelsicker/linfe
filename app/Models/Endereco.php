<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id',
        'principal',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'cidade_id',
        'referencia',
    ];

    public function cidades(): HasMany
    {
        return $this->hasMany(Cidade::class);
    }
}
