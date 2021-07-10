<?php


namespace App\Services\Sync;


use App\Exceptions\Entrega\EntregaNotCreatedException;
use App\Exceptions\Pagamento\PagamentoNotCreatedException;
use App\Exceptions\Pedido\PedidoImportErrorException;
use App\Exceptions\PedidoItem\PedidoItemNotCreatedException;
use App\Externals\PedidoApi;
use App\Models\Cliente;
use App\Models\FormaDePagamento;
use App\Models\Pedido;
use App\Models\PedidoEntrega;
use App\Models\PedidoPagamento;
use App\Models\Situacao;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Throwable;

class PedidoSync
{
    public function __construct(
        private ClienteSync $clienteSync,
        private PedidoItemSync $pedidoItemSync,
        private EnderecosSync $enderecosSync,
        private SituacaoSync $situacaoSync
    ) {}

    /**
     * @param Carbon $since
     * @return int
     * @throws PedidoImportErrorException
     */
    public function run(Carbon $since): int
    {
        try {
            $this->situacaoSync->run();
            $pedidosApi = PedidoApi::since($since);

            foreach ($pedidosApi as $pedidoApi) {
                $this->pedidoStore($pedidoApi);
            }

            return count($pedidosApi);
        } catch (Throwable $exception) {
            throw new PedidoImportErrorException(
                "Erro ao sincronizar os pedidos",
                Response::HTTP_BAD_REQUEST,
                $exception
            );
        }
    }

    /**
     * @param object $pedidoApi
     * @return void
     * @throws PedidoImportErrorException
     */
    private function pedidoStore(object $pedidoApi): void
    {
        try {
            $cliente = $this->clienteSync->run($pedidoApi->cliente);
            $situacao = Situacao::apiImport((array) $pedidoApi->situacao);

            $pedido = $this->pedidoSync($pedidoApi,$cliente, $situacao);
            $this->entregaSync($pedido, $cliente, $pedidoApi->endereco_entrega);
            $this->pagamentosSync($pedido, $pedidoApi->pagamentos);

            foreach ($pedidoApi->itens ?? [] as $item) {
                $this->pedidoItemSync->run($item, $pedido->id);
            }
        } catch (Throwable $exception) {
            throw new PedidoImportErrorException(
                "Erro ao importar o pedido: ",
                Response::HTTP_BAD_REQUEST,
                $exception
            );
        }
    }

    /**
     * @param object $pedidoApi
     * @param Cliente $cliente
     * @param Situacao $situacao
     * @return Pedido
     */
    private function pedidoSync(
        object $pedidoApi,
        Cliente $cliente,
        Situacao $situacao
    ): Pedido {
        try {
            return Pedido::updateOrCreate([
                'pessoa_id' => $cliente->id,
                'cliente_obs' => $pedidoApi->cliente_obs,
                'cupom_desconto' => $pedidoApi?->cupom_desconto?->codigo,
                'peso_real' => $pedidoApi->peso_real,
                'valor_desconto' => $pedidoApi->valor_desconto,
                'valor_envio' => $pedidoApi->valor_envio,
                'valor_subtotal' => $pedidoApi->valor_subtotal,
                'valor_total' => $pedidoApi->valor_total,
                'situacao_id' => $situacao->id,
                'li_id' => $pedidoApi->numero
            ], ['li_id' => $pedidoApi->numero]);
        } catch (Throwable $exception) {
            throw new PedidoItemNotCreatedException(
                "Erro ao salvar o Pedido: {$pedidoApi->numero}",
                Response::HTTP_BAD_REQUEST,
                $exception,
            );
        }
    }

    /**
     * @param Pedido $pedido
     * @param Cliente $cliente
     * @param object $enderecoApi
     * @return PedidoEntrega
     * @throws EntregaNotCreatedException
     */
    public function entregaSync(
        Pedido $pedido,
        Cliente $cliente,
        object $enderecoApi
    ): PedidoEntrega {
        try {
            $endereco = $this->enderecosSync->run([$enderecoApi],$cliente->id)?->first();

            return PedidoEntrega::firstOrCreate([
                'pedido_id' => $pedido->id,
                'endereco_id' => $endereco->id
            ]);
        } catch (Throwable $exception) {
            throw new EntregaNotCreatedException(
                "Erro ao criar a Entrega",
                Response::HTTP_BAD_REQUEST,
                $exception
            );
        }
    }

    /**
     * @param Pedido $pedido
     * @param iterable $pagamentosApi
     * @return Collection
     * @throws PagamentoNotCreatedException
     */
    private function pagamentosSync(
        Pedido $pedido,
        iterable $pagamentosApi
    ): Collection {
        try {
            foreach ($pagamentosApi as $pagamentoApi) {
                $formaDePagamento = FormaDePagamento::apiImport((array) $pagamentoApi->forma_pagamento);
                $pagamento = collect($pagamentoApi)->merge([
                    'forma_id' => $formaDePagamento->id,
                    'pedido_id' => $pedido->id,
                    'tipo' => $pagamentoApi->pagamento_tipo,
                    'numero_de_parcelas' => $pagamentoApi->parcelamento?->numero_parcelas ?? null,
                    'valor_das_parcelas' => $pagamentoApi->parcelamento?->valor_parcela ?? null,
                ]);
                $pagamentos[] = PedidoPagamento::apiImport($pagamento->toArray());
            }
            return collect($pagamentos ?? []);
        } catch (Throwable $exception) {
            throw new PagamentoNotCreatedException(
                "Erro ao criar algum Pagamento",
                Response::HTTP_BAD_REQUEST,
                $exception
            );
        }
    }
}
