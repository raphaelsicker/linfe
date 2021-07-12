<?php

namespace Database\Factories;

use App\Enums\EmailType;
use App\Models\Cliente;
use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarcaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Marca::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => 'Jessicat',
            'apelido' => 'jessicat',
            'descricao' => 'Marca da Jessicat',
            'li_id' => null,
        ];
    }
}
