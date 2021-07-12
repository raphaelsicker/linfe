<?php

namespace Database\Factories;

use App\Enums\PriceType;
use App\Models\Produto;
use App\Models\ProdutoPreco;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoPrecoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProdutoPreco::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo' => PriceType::SALE,
            'valor' => 20,
            'produto_id' => $this->getFakeProduto(),
        ];
    }

    private function getFakeProduto(): Produto | Collection
    {
        return Produto::first()
            ?? Produto::factory()->create();
    }
}
