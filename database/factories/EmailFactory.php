<?php

namespace Database\Factories;

use App\Enums\EmailType;
use App\Models\Cliente;
use App\Models\Email;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Email::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo' => EmailType::PERSONAL,
            'email' => 'raphaelsicker@hotmail.com'
        ];
    }
}
