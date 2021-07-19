<?php

namespace Database\Factories;

use App\Enums\PhoneType;
use App\Models\Cliente;
use App\Models\Telefone;
use Illuminate\Database\Eloquent\Factories\Factory;

class TelefoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Telefone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo' => PhoneType::CELL,
            'numero' => '21983881123'
        ];
    }
}
