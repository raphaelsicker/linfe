<?php

namespace Database\Factories;

use App\Enums\DocumentType;
use App\Enums\PhoneType;
use App\Models\Cidade;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Situacao;
use App\Models\Telefone;
use App\Models\Transportadora;
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
            'empresa_id' => $this->getFakeEmpresa(),
            'cliente_id' => $this->getFakeCliente(),
            'transportadora_id' => $this->getFakeTranspotadora(),
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

    private function getFakeTranspotadora(): Transportadora
    {
        return Transportadora::factory()
            ->hasDocumentos([
                'tipo' => DocumentType::CNPJ,
                'documento' => '16.274.349/0001-51',
            ])
            ->hasDocumentos([
                'tipo' => DocumentType::IE,
                'documento' => '61.785.80-9',
            ])
            ->hasEnderecos([
                'principal' => true,
                'endereco' => 'R. Raul de Oliveira Rodrigues',
                'numero' => '74',
                'complemento' => 'loja 108',
                'bairro' => 'Centro',
                'cep' => '28893052',
                'cidade_id' => Cidade::nome('Rio das Ostras')->first()?->id,
            ])
            ->create();
    }

    private function getFakeEmpresa(): Empresa
    {
        return Empresa::factory()
                ->hasDocumentos([
                    'tipo' => DocumentType::CNPJ,
                    'documento' => '68.376.173/0001-42',
                ])
                ->hasEmails([
                    'email' => 'raphaelsicker@hotmail.com'
                ])
                ->hasTelefones([
                    'numero' => '21912345678'
                ])
                ->hasEnderecos([
                    'principal' => true,
                    'endereco' => 'Rua Ametista',
                    'numero' => '41',
                    'complemento' => 'casa 1',
                    'bairro' => 'Ouro Verde',
                    'cep' => '28895442',
                    'cidade_id' => Cidade::nome('Rio das Ostras')->first()?->id,
                ])
                ->create();
    }

    private function getFakeCliente(): Cliente
    {
        return Cliente::factory()
                ->hasDocumentos()
                ->hasEmails()
                ->hasTelefones()
                ->hasEnderecos()
                ->create();
    }

    private function getFakeSituacao(): Situacao
    {
        return Situacao::first()
            ?? Situacao::factory()->create();
    }
}
