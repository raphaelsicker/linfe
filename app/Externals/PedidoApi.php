<?php


namespace App\Externals;


use App\Externals\Base\LiApi;
use App\Externals\Traits\FindTrait;
use App\Externals\Traits\GetTrait;
use Carbon\Carbon;

class PedidoApi
{
    public const URL_GET = 'pedido/search/';
    public const URL_FIND = 'pedido/#id/';

    use FindTrait;

    /**
     * @param Carbon $since
     * @return array
     */
    public static function since(Carbon $since): array
    {
        return self::get([
            'since_atualizado' => $since->toDateTimeLocalString()
        ]);
    }

    /**
     * @param array $params
     * @return array
     */
    public static function get(array $params = []): array
    {
        $response = LiApi::get(self::URL_GET, $params);

        if($response->ok()) {
            foreach($response->object()?->objects ?? [] as $pedido) {
                $pedidos[] = self::find($pedido->numero);
            }
        }

        return $pedidos ?? [];
    }
}
