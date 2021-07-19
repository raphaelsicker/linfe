<?php

namespace Database\Factories;

use App\Models\Cidade;
use App\Models\Cliente;
use App\Models\Endereco;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Endereco::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'principal' => true,
            'endereco' => 'Rua Riachuelo',
            'numero' => '100',
            'complemento' => 'apto 101',
            'bairro' => 'Centro',
            'cep' => '20230014',
            'cidade_id' => Cidade::nome('Rio de Janeiro')->first()?->id,
            'referencia' => 'Casa amarela',
        ];
    }
}
