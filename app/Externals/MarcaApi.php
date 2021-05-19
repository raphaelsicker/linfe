<?php


namespace App\Externals;


use App\Externals\Base\LiApi;
use App\Helpers\Std;

class MarcaApi
{
    public const URL_FIND = 'marca/#id';

    /**
     * @param int $id
     * @return array
     */
    public static function find(int $id): array
    {
        $response = LiApi::find(self::URL_FIND, $id);

        if($response->ok()) {
            return Std::toArray($response->object());
        }

        return [];
    }
}
