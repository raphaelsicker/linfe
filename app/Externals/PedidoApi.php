<?php


namespace App\Externals;


use App\Externals\Base\LiApi;
use App\Helpers\Std;
use Carbon\Carbon;

class PedidoApi
{
    public const URL_GET = 'pedido/search/';
    public const URL_FIND = 'pedido/#id/';

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

    /**
     * @param int $id
     * @return array
     */
    public static function find(int $id): array
    {
        $response = LiApi::find(self::URL_FIND, $id);

        if($response->ok()) {
            return Std::toArray($response->object());
        }

        return [];
    }

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
}
