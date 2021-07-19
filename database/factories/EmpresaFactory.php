<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\PersonType;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Empresa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => 'Jessicat',
            'razao_social' => 'Jessicat Boutique',
            'data_nascimento' => '2021-02-01',
            'tipo_de_pessoa' => PersonType::PJ,
        ];
    }
}
