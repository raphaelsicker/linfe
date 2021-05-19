<?php


namespace App\Helpers;


use Throwable;

class Std
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
}
