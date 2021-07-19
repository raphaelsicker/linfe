<?php


namespace App\Helpers;

/**
 * Class Str
 * @package App\Helpers
 */
class Str extends \Illuminate\Support\Str
{
    /**
     * Str::replace('Nome: #nome #sobrenome', ['nome' => 'João', 'sobrenome' => 'Silva']) retorna 'Nome: João Silva'
     * @param string $string
     * @param array $array
     * @return string
     */
    public static function replaceFromVars(string $string, array $array): string
    {
        foreach ($array as $key => $value) {
            $string = self::of($string)
                ->replace('#' . $key, $value);
        }

        return $string;
    }

    /**
     * Adiciona um prefixo à uma string
     *
     * @param string|null $string
     * @param string $prefix
     * @param bool $force
     * @return string
     */
    public static function addPrefix(?string $string, string $prefix): string
    {
        if(empty($string)) {
            return '';
        }

        return $prefix . $string;
    }

    /**
     * Adiciona um sufixo à uma string
     *
     * @param string|null $string
     * @param string $suffix
     * @return string
     */
    public static function addSuffix(?string $string, string $suffix): string
    {
        if(empty($string)) {
            return '';
        }

        return $string . $suffix;
    }
}
