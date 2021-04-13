<?php


namespace App\Externals;


use App\Externals\Base\LiApi;

class LiApiCliente extends LiApi
{
    protected string $urlGet = 'cliente/';
    protected string $urlFind = 'cliente/#id/';
}
