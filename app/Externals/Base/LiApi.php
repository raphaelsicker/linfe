<?php


namespace App\Externals\Base;


use App\Helpers\Arr;
use App\Helpers\Str;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class LiApi
{
    protected string $urlGet = '/';
    protected string $urlFind = '/#id/';

    /**
     * @param array $query
     * @return Response
     */
    public static function get(array $query = []): Response
    {
        return Http::get(
            self::makeUrl((new static())->urlGet),
            Arr::merge($query, self::authQueries()) ?: null
        );
    }

    /**
     * @param string $id
     * @param array $query
     * @return Response
     */
    public static function find(string $id, array $query = []): Response
    {
        $relativePath = Str::replace((new static())->urlFind, ['id' => $id]);

        return Http::get(
            self::makeUrl($relativePath),
            Arr::merge($query, self::authQueries()) ?: null
        );
    }

    /**
     * @param string $relativePath
     * @return string
     */
    private static function makeUrl(string $relativePath): string
    {
        return Str::replace('#baseUrl/#version/#relativePath', [
            'baseUrl' => env('LI_API_BASE_URL'),
            'version' => env('LI_API_VERSION'),
            'relativePath' => $relativePath
        ]);
    }

    /**
     * @return array|null
     */
    private static function authQueries(): ?array
    {
        return [
            'chave_api' => env('LI_API_KEY_ERP'),
            'chave_aplicacao' => env('LI_API_KEY_JESSICAT')
        ];
    }
}
