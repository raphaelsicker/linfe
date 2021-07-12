<?php

namespace Database\Seeders;

use App\Models\Cidade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SituacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Cidade $cidade */
        $cidade = app(Cidade::class);
        $chaves = $this->chaves();

        foreach($this->dados() as $linha) {
            $dados = array_combine($chaves, $linha);
            $campos[] = Arr::only($dados, $cidade->getFillable());
        }

        $cidade->insert($campos);
    }

    private function chaves()
    {
        return ['codigo', 'nome', 'li_id'];
    }

    private function dados()
    {
        return [
            ['aguardando_pagamento','Aguardando pagamento',2],
            ['em_producao','Em produção',17],
            ['pagamento_devolvido','Pagamento devolvido',7],
            ['pagamento_em_analise','Pagamento em análise',3],
            ['pedido_chargeback','Pagamento em chargeback',16],
            ['pagamento_em_disputa','Pagamento em disputa',6],
            ['pedido_cancelado','Pedido Cancelado',8],
            ['pedido_efetuado','Pedido Efetuado',9],
            ['pedido_em_separacao','Pedido em separação',15],
            ['pedido_entregue','Pedido Entregue',14],
            ['pedido_enviado','Pedido Enviado',11],
            ['pedido_pago','Pedido Pago',4],
            ['pronto_para_retirada','Pedido pronto para retirada',13]
        ];
    }
}
