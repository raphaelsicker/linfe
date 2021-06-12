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

    /**
     * Retornar o Id pela chave passada
     * Caso a chave seja negativa contará o elemento de trás pra frente
     * @param string $url
     * @param int $key
     * @return string|null
     */
    public static function extractParentId(string $url, int $key = -3): ?string
    {
        $urlFields = Str::of( $url)->explode('/');

        if($key < 0) {
            $key = $urlFields->count() + $key;
        }

        return $urlFields->get($key);
    }
}
