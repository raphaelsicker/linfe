<?php


namespace App\Helpers;


class Url
{
    /**
     * Deve ser passado como no seguinte formato: "/api/v1/pedido/544" onde 544 será retornado
     * @param string $url
     * @return string
     */
    public static function extractId(string $url): string
    {
        return Str::of( $url)
            ->explode('/')
            ->last();
    }
}
