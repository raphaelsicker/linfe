<?php

namespace App\Models;



use App\Models\Base\Model;

class Email extends Model
{
    protected $fillable = [
        'pessoa_id',
        'tipo',
        'email'
    ];
}
