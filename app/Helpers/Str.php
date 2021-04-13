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
    public static function replace(string $string, array $array): string
    {
        foreach ($array as $key => $value) {
            $string = self::of($string)
                ->replace('#' . $key, $value);
        }

        return $string;
    }

}
