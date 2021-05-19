<?php


namespace App\Externals;


use App\Externals\Base\LiApi;
use App\Helpers\Std;

class ProdutoApi
{
    public const URL_FIND = 'produto/#id/?descricao_completa=1';

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
