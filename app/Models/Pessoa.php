<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Pessoa
 * @package App\Models
 * @mixin Builder
 * @property string nome
 * @property string razao_social
 * @property string sexo
 * @property string data_nascimento
 * @property string tipo_de_pessoa
 * @property string grupo_id
 * @property string li_id
 *
 * @property Endereco endereco
 * @property Telefone celular
 * @property Telefone fixo
 * @property Telefone comercial
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

    public function endereco(): HasOne
    {
        return $this->hasOne(Endereco::class, 'pessoa_id')->principal();
    }

    public function telefones(): HasMany
    {
        return $this->hasMany(Telefone::class, 'pessoa_id');
    }

    public function celular(): HasOne
    {
        return $this->hasOne(Telefone::class, 'pessoa_id')->celular();
    }

    public function fixo(): HasOne
    {
        return $this->hasOne(Telefone::class, 'pessoa_id')->fixo();
    }

    public function comercial(): HasOne
    {
        return $this->hasOne(Telefone::class, 'pessoa_id')->comercial();
    }

    public function newQuery(): Builder
    {
        $currentClass = (new static())::class;

        return parent::newQuery()
            ->where('classe', $currentClass);
    }

    public function cpf(): ?string
    {
        return $this->documentos()
            ->cpf()
            ->first()
            ?->documento ?? null;
    }

    public function cnpj(): ?string
    {
        return $this->documentos()
            ->cnpj()
            ->first()
            ?->documento ?? null;
    }

    public function ie(): ?string
    {
        return $this->documentos()
            ->ie()
            ->first()
            ?->documento ?? null;
    }

    public function im(): ?string
    {
        return $this->documentos()
            ->im()
            ->first()
            ?->documento ?? null;
    }

    public function emailPessoal(): ?string
    {
        return $this->emails()
                ->pessoal()
                ->first()
                ?->email ?? null;
    }
}
