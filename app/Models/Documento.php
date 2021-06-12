<?php

namespace App\Models;

use App\Models\Base\Model;

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
