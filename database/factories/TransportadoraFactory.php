<?php

namespace Database\Factories;

use App\Enums\PersonType;
use App\Models\Transportadora;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransportadoraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transportadora::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => 'Jadlog',
            'razao_social' => 'Jadlog Transportadora',
            'tipo_de_pessoa' => PersonType::PJ,
        ];
    }
}
