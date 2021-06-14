<?php

namespace App\Models;

use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class FormaDePagamento extends Model
{
    protected $fillable = [
        'codigo',
        'nome',
        'li_id',
    ];
}
