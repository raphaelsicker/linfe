<?php


namespace App\Enums\Base;

use Illuminate\Support\Arr;

abstract class Enum
{
    /**
     * Retorna todos os enums
     * @return array
     */
    public static function all(): array
    {
        return (new static())->all;
    }

    /**
     * Retorna as chaves com as descrições do Enum
     * @return array
     */
    public static function keys(): array
    {
        return array_keys(self::all());
    }

    /**
     * Retorna a chave do Enum
     * @param string $value
     * @return string
     */
    public static function getKey(string $value): string
    {
        return array_search($value, self::all());
    }

    /**
     * Alias de self::all()
     * Retorna as chaves com as descrições do Enum
     * @return array
     */
    public static function get(): array
    {
        return self::all();
    }

    /**
     * Retorna o valor do Enum passando uma chave
     * @param string $key
     * @param mixed $default
     * @return string | null
     */
    public static function find(string $key, $default = null): ?string
    {
        return Arr::get(self::all(), $key) ?? $default;
    }

    /**
     * Retorna os valores
     * @return array
     */
    public static function values(): array
    {
        return array_values(self::all());
    }
}
