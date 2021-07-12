<?php

namespace Database\Factories;

use App\Enums\PhoneType;
use App\Enums\PriceType;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;
use App\Models\Situacao;
use App\Models\Telefone;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class PedidoItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PedidoItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $produto = $this->getFakeProduto();

        return [
            'pedido_id' => $this->getFakePedido(),
            'produto_id' => $produto->id,
            'nome' => $produto->nome,
            'quantidade' => 1,
            'ncm' => $produto->ncm,
            'altura' => $produto->altura,
            'largura' => $produto->largura,
            'profundidade' => $produto->profundidade,
            'peso' => $produto->peso,
            'li_id' => null
        ];
    }

    private function getFakePedido() : Pedido | Collection
    {
        return Pedido::first()
            ?? Pedido::factory()->create();
    }

    private function getFakeProduto() : Produto | Collection
    {
        return Produto::first()
            ?? Produto::factory()
                ->hasPrecos(['tipo' => PriceType::COST, 'valor' => 60.5])
                ->hasPrecos(['tipo' => PriceType::SALE, 'valor' => 100])
                ->create();
    }
}
