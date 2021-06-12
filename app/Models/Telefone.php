<?php

namespace App\Models;


use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Telefone extends Model
{
    protected $fillable = [
        'pessoa_id',
        'tipo',
        'numero'
    ];

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class);
    }
}
