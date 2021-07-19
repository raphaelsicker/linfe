<?php

namespace App\Models;

use App\Enums\EmailType;
use App\Models\Base\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Email
 * @package App\Models
 * @mixin Builder
 *
 * @property int id
 * @property int pessoa_id
 * @property int tipo
 * @property string email
 */
class Email extends Model
{
    protected $fillable = [
        'pessoa_id',
        'tipo',
        'email'
    ];

    /**
     * Escopo para retornar apenas email pessoal
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePessoal(Builder $query): Builder
    {
        return $query->where('tipo', EmailType::PERSONAL);
    }
}
