<?php


namespace App\Helpers;


class Arr extends \Illuminate\Support\Arr
{
    /**
     * @param array ...$arrays
     * @return array
     */
    public static function merge(array ...$arrays): array
    {
        $merged = [];

        foreach($arrays as $array) {
            $merged = array_merge($merged, $array);
        }

        return $merged;
    }
}
