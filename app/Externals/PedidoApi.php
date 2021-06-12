<?php


namespace App\Externals;


use App\Externals\Traits\FindTrait;
use App\Externals\Traits\GetTrait;
use Carbon\Carbon;

class PedidoApi
{
    public const URL_GET = 'pedido/search/';
    public const URL_FIND = 'pedido/#id/';

    use GetTrait;
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
}
