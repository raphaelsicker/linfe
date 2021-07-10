<?php


namespace App\Externals\Traits;


use App\Enums\ReturnType;
use App\Externals\Base\LiApi;
use App\Helpers\Obj;

trait GetTrait
{
    /**
     * @param array $params
     * @param string $returnType
     * @return array|object|null
     */
    public static function get(
        array $params = [],
        string $returnType = ReturnType::OBJECT
    ): array|object|null {
        $response = LiApi::get(self::URL_GET, $params);

        if(!$response->ok()) {
            return null;
        }

        $objects = $response->object()?->objects;

        return $returnType == ReturnType::ARRAY
            ? Obj::toArray((object) $objects)
            : $objects;
    }
}
