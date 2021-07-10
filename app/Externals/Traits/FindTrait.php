<?php


namespace App\Externals\Traits;


use App\Enums\ReturnType;
use App\Externals\Base\LiApi;
use App\Helpers\Obj;

trait FindTrait
{
    /**
     * @param int $id
     * @param string $returnType
     * @return array|object|null
     */
    public static function find(
        int $id,
        string $returnType = ReturnType::OBJECT
    ): array|object|null {
        $response = LiApi::find(self::URL_FIND, $id);

        if(!$response->ok()) {
            return null;
        }

        return $returnType == ReturnType::ARRAY
            ? Obj::toArray($response->object())
            : $response->object();


    }
}
