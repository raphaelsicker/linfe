<?php


namespace App\Helpers;


class Arr extends \Illuminate\Support\Arr
{
    /**
     * Retorna os itens do array que possuam a chave assinalada preenchida
     * @param array[] $array
     * @param string $key
     * @return array
     */
    public static function havingKey(array $array, string $key): array
    {
        return self::where($array, fn($value) => !empty($value[$key]));
    }

    /**
     * Retorna apenas os valores preenchidos de um array
     * @param array $array
     * @param callable|null $callback
     * @param int $mode
     * @return array
     */
    public static function filter(
        array $array,
        ?callable $callback = null,
        int $mode = 0
    ): array {
        return array_filter($array, $callback, $mode);
    }

    /**
     * Faz merge um ou mais elementos
     * @param array ...$arrays
     * @return array
     */
    public static function merge(array ...$arrays): array
    {
        foreach($arrays as $array) {
            $merged = array_merge($merged ?? [], $array);
        }

        return $merged;
    }

    /**
     * Faz merge e retorna apenas os valores preenchidos dos arrays passados
     * @param mixed ...$arrays
     * @return array
     */
    public static function mergeNotNull(array ...$arrays): array
    {
        foreach($arrays as $array) {
            $merged = array_merge(
                $merged ?? [],
                self::filter($array, fn($value) => !is_null($value))
            );
        }

        return $merged;
    }
}
