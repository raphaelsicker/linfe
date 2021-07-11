<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\PersonType;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => 'Maria da Consolação',
            'razao_social' => null,
            'sexo' => Gender::FEMALE,
            'data_nascimento' => '1998-01-01',
            'tipo_de_pessoa' => PersonType::PF,
            'grupo_id' => null,
            'li_id' => null
        ];
    }
}
