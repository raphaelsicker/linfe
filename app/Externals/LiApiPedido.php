<?php


namespace App\Externals;


use App\Externals\Base\LiApi;

class LiApiPedido extends LiApi
{
    protected string $urlGet = 'pedido/search/';
    protected string $urlFind = 'pedido/#id/';
}
