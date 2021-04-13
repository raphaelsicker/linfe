<?php


namespace App\Services;


use App\Externals\Base\LiApi;
use App\Externals\LiApiPedido;
use App\Helpers\Str;
use Carbon\Carbon;

class PedidoService
{
    public function atualizar(?Carbon $atualizadoEm = null)
    {
        $pedidosIds = $this->buscarIdsDosUltimosPedidos(
            $atualizadoEm ?? Carbon::now('-03:00')->subDay(3)
        );

        foreach ($pedidosIds as $pedidosId) {
            $pedido = $this->buscarPedido($pedidosId);
            $this->salvarPedido($pedido);
        }
    }

    /**
     * @param Carbon $atualizadoEm
     * @return array
     */
    private function buscarIdsDosUltimosPedidos(Carbon $atualizadoEm): array
    {
        $resposta = LiApiPedido::get(['since_atualizado' => $atualizadoEm->toDateTimeLocalString()]);

        if($resposta->ok()) {
            $pedidos = $resposta->object()?->objects;
            $pedidosIds = [];

            foreach($pedidos ?? [] as $pedido) {
                $pedidosIds[] = $pedido?->numero;
            }

            return $pedidosIds;
        }

        return [];
    }

    /**
     * Busca os dados completos do Pedido
     * @param string $id
     * @return object|null
     */
    private function buscarPedido(string $id): ?object
    {
        $resposta = LiApiPedido::find($id);

        if($resposta->ok()) {
            return $resposta->object();
        }

        return null;
    }

    private function salvarPedido(?object $pedido)
    {
    }

}
