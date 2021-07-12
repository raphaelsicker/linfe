<?php

namespace Database\Factories;

use App\Models\Marca;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Produto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => 'Vestido Rosa',
            'apelido' => null,
            'descricao_completa' => 'Vestido Rosa',
            'ativo' => true,
            'bloqueado' => false,
            'removido' => false,
            'destaque' => true,
            'usado' => false,
            'marca_id' => $this->getFakeMarca(),
            'pai_id' => null,
            'altura' => 7,
            'largura' => 24,
            'peso' => 0.75,
            'profundidade' => 26,
            'ncm' => 62044300,
            'sku' => 'UDQ5H737M',
            'li_id' => null
        ];
    }

    private function getFakeMarca(): Marca | Collection
    {
        return Marca::first()
            ?? Marca::factory()->create();
    }
}
