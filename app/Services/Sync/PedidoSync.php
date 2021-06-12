<?php


namespace App\Services\Sync;


use App\Externals\PedidoApi;
use App\Helpers\Arr;
use Carbon\Carbon;
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
            return false;
        }
    }

    /**
     * @param object $pedido
     * @return array|false
     */
    private function storePedido(object $pedido)
    {
        $clienteId = $this->clienteSync->run($pedido->cliente);

        foreach ($pedido->itens ?? [] as $item) {
            [$produtoId, $variacoes] = $this->produtoSync->run($item);
        }

        $pedido = [
            'cliente_id' => $clienteId,
            'items' => $items
        ];

        return $pedido ?? false;
    }

}
