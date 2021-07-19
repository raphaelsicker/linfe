<?php

namespace Database\Factories;

use App\Enums\DocumentType;
use App\Models\Cliente;
use App\Models\Documento;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Documento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo' => DocumentType::CPF,
            'documento' => '615.521.110-83',
            'orgao_emissor' => null,
            'data_emissao' => null
        ];
    }
}
