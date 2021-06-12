<?php


namespace App\Helpers;


use Illuminate\Support\Collection;
use stdClass;
use Throwable;

class Obj
{
    /**
     * @param object $object
     * @return array
     */
    public static function toArray(object $object): array
    {
        try{
            return json_decode(self::toJson($object), true);
        } catch (Throwable) {
            return [];
        }
    }

    /**
     * @param object $object
     * @return Collection
     */
    public static function toCollection(object $object): Collection
    {
        $array = self::toArray($object);
        return collect($array);
    }

    /**
     * @param object $object
     * @return string
     */
    public static function toJson(object $object): string
    {
        try {
            return json_encode($object);
        } catch (Throwable) {
            return '';
        }
    }

    /**
     * Faz merge e retorna apenas os valores preenchidos dos arrays passados
     * @param object ...$objects
     * @return object
     */
    public static function mergeNotNull(object ...$objects): object
    {
        $merged = new StdClass();

        foreach($objects as $object) {
            foreach ($object as $key => $value) {
                if(!is_null($value)) {
                    $merged->$key = $value;
                }
            }
        }

        return $merged;
    }
}
