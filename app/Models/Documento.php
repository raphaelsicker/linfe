<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'pessoa_id',
        'tipo',
        'documento',
        'orgao_emissor',
        'data_emissao'
    ];
}
