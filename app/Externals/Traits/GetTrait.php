<?php


namespace App\Externals\Traits;


use App\Externals\Base\LiApi;

trait GetTrait
{
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
