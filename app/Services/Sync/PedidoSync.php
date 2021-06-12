<?php


namespace App\Services\Sync;


use App\Exceptions\Entrega\EntregaNotCreatedException;
use App\Exceptions\Pedido\PedidoImportErrorException;
use App\Externals\PedidoApi;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\PedidoEntrega;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Throwable;

class PedidoSync
{
    public function __construct(
        private ClienteSync $clienteSync,
        private ProdutoSync $produtoSync,
        private EnderecosSync $enderecosSync
    ) {}

    /**
     * @param Carbon|null $since
     * @return void
     * @throws PedidoImportErrorException
     */
    public function run(?Carbon $since = null)
    {
        try {
            $pedidosApi = PedidoApi::since($since  ?: Carbon::now('-03:00')->subDays(3));

            foreach ($pedidosApi as $pedidoApi) {
                $this->storePedido($pedidoApi);
            }
        } catch (Throwable $t) {
            throw new PedidoImportErrorException("Erro ao sincronizar os pedidos", Response::HTTP_BAD_REQUEST, $t);
        }
    }

    /**
     * @param object $pedidoApi
     * @return array|false
     */
    private function storePedido(object $pedidoApi)
    {
        try {
            $cliente = $this->clienteSync->run($pedidoApi->cliente);

            foreach ($pedidoApi->itens ?? [] as $item) {
                $items[] = $this->produtoSync->run($item);
            }

            $pedido = Pedido::updateOrCreate([
                'pessoa_id' => $cliente->id,
                'cliente_obs' => $pedidoApi->cliente_obs,
                'cupom_desconto' => $pedidoApi->cupom_desconto,
                'peso_real' => $pedidoApi->peso_real,
                'valor_desconto' => $pedidoApi->valor_desconto,
                'valor_envio' => $pedidoApi->valor_envio,
                'valor_subtotal' => $pedidoApi->valor_subtotal,
                'valor_total' => $pedidoApi->valor_total,
                'li_id' => $pedidoApi->numero
            ], ['li_id' => $pedidoApi->numero]);

            $entrega = $this->entregaSync($pedido, $cliente, $pedidoApi->endereco_entrega);

            return $pedido ?? false;
        } catch (Throwable $exception) {
            throw new PedidoImportErrorException(
                "Erro ao importar o pedido: ",
                Response::HTTP_BAD_REQUEST,
                $exception
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

}
