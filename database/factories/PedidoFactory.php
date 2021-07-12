<?php

namespace Database\Factories;

use App\Enums\PhoneType;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Situacao;
use App\Models\Telefone;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pedido::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pessoa_id' => $this->getFakeCliente(),
            'situacao_id' => $this->getFakeSituacao(),
            'cliente_obs' => null,
            'cupom_desconto' => null,
            'peso_real' => 0,
            'valor_desconto' => 0,
            'valor_envio' => 10,
            'valor_subtotal' => 10,
            'valor_total' => 10,
            'li_id' => null
        ];
    }

    private function getFakeCliente(): Cliente | Collection
    {
        return Cliente::first()
            ?? Cliente::factory()
                ->hasDocumentos()
                ->hasEmails()
                ->hasTelefones()
                ->hasEnderecos()
                ->create();
    }

    private function getFakeSituacao(): Situacao | Collection
    {
        return Situacao::first()
            ?? Situacao::factory()->create();
    }
}
