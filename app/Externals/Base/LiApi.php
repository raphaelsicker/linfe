<?php


namespace App\Externals\Base;


use App\Helpers\Arr;
use App\Helpers\Str;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\ArrayShape;

class LiApi
{
    /**
     * @param string $relativePath
     * @param array $query
     * @return Response
     */
    public static function get(
        string $relativePath,
        array $query = []
    ): Response {
        return Http::get(
            self::makeUrl($relativePath),
            Arr::merge($query, self::authQueries()) ?: null
        );
    }

    /**
     * @param string $relativePath
     * @param string $id
     * @param array $query
     * @return Response
     */
    public static function find(
        string $relativePath,
        string $id,
        array $query = []
    ): Response {
        $relativePath = Str::replaceFromVars($relativePath, ['id' => $id]);

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
        return Str::replaceFromVars('#baseUrl/#version/#relativePath', [
            'baseUrl' => env('LI_API_BASE_URL'),
            'version' => env('LI_API_VERSION'),
            'relativePath' => $relativePath
        ]);
    }

    #[ArrayShape([
        'chave_api' => "string",
        'chave_aplicacao' => "string"
    ])]
    private static function authQueries(): array
    {
        return [
            'chave_api' => env('LI_API_KEY_ERP'),
            'chave_aplicacao' => env('LI_API_KEY_JESSICAT')
        ];
    }
}
