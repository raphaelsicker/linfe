<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Pessoa
 * @package App\Models
 * @mixin Builder
 */
class Pessoa extends Model
{
    protected $table = 'pessoas';

    protected $fillable = [
        'nome',
        'razao_social',
        'sexo',
        'data_nascimento',
        'tipo_de_pessoa',
        'grupo_id',
        'li_id'
    ];

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class, 'pessoa_id');
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class, 'pessoa_id');
    }

    public function enderecos(): HasMany
    {
        return $this->hasMany(Endereco::class, 'pessoa_id');
    }

    public function telefones(): HasMany
    {
        return $this->hasMany(Telefone::class, 'pessoa_id');
    }
}
