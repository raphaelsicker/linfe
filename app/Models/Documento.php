<?php

namespace App\Models;

use App\Enums\DocumentType;
use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Builder;

class Documento extends Model
{
    protected $fillable = [
        'pessoa_id',
        'tipo',
        'documento',
        'orgao_emissor',
        'data_emissao'
    ];

    /**
     * Retorna somente os CPFs
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeCpf(Builder $query): Builder
    {
        return $query->where('tipo', DocumentType::CPF);
    }

    /**
     * Retorna somente os CNPJs
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeCnpj(Builder $query): Builder
    {
        return $query->where('tipo', DocumentType::CNPJ);
    }

    /**
     * Retorna somente as Incrições Estaduais
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeIe(Builder $query): Builder
    {
        return $query->where('tipo', DocumentType::IE);
    }

    /**
     * Retorna somente as Incrições Municipais
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeIm(Builder $query): Builder
    {
        return $query->where('tipo', DocumentType::IM);
    }
}
