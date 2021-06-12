<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'li_id'
    ];

    public function variacoes(): HasMany
    {
        $this->hasMany(Variacao::class, 'grade_id');
    }
}
