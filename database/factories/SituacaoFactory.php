<?php

namespace Database\Factories;

use App\Enums\PhoneType;
use App\Models\Cliente;
use App\Models\Situacao;
use App\Models\Telefone;
use Illuminate\Database\Eloquent\Factories\Factory;

class SituacaoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Situacao::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => 'pedido_em_separacao',
            'nome' => 'Pedido em separação',
            'li_id' => 15
        ];
    }
}
