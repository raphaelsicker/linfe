<?php


namespace App\Services\Sync;


use App\Externals\PedidoApi;
use App\Helpers\Arr;
use Carbon\Carbon;

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

        $ultimosPedidos = PedidoApi::since($since);

        foreach ($ultimosPedidos as $pedido) {
            $this->storePedido($pedido);
        }

        return true;
    }

    private function storePedido(array $pedido)
    {
        $clienteId = $this->clienteSync->run($pedido['cliente']);

        foreach ($pedido['itens'] ?? [] as $item) {
            $items = $this->produtoSync->run($item);
        }


        $pedido = [
            'cliente_id' => $clienteId,
            'items' => $items
        ];

        return $pedido ?? false;
    }

}
