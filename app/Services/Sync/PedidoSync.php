<?php


namespace App\Services\Sync;


use App\Exceptions\Pedido\PedidoImportErrorException;
use App\Externals\PedidoApi;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Throwable;

class PedidoSync
{
    public function __construct(
        private ClienteSync $clienteSync,
        private ProdutoSync $produtoSync
    ) {}

    /**
     * @param Carbon|null $since
     * @return false
     */
    public function run(?Carbon $since = null)
    {
        if(!$since) {
            $since = Carbon::now('-03:00')->subDays(3);
        }

        try {
            foreach (PedidoApi::since($since) as $pedido) {
                $this->storePedido($pedido);
            }

            return true;
        } catch (Throwable $t) {
            throw new PedidoImportErrorException("Erro ao importar o pedido", Response::HTTP_BAD_REQUEST, $t);
        }
    }

    /**
     * @param object $pedido
     * @return array|false
     */
    private function storePedido(object $pedido)
    {
        $cliente = $this->clienteSync->run($pedido->cliente);

        foreach ($pedido->itens ?? [] as $item) {
            $items[] = $this->produtoSync->run($item);
        }

        $pedido = [
            'cliente_id' => $cliente->id,

        ];

        $entrega = $this->entregaSync->run($pedidoId, $cliente);

        return $pedido ?? false;
    }

}
