<?php


namespace App\Services\Sync;


use App\Enums\ReturnType;
use App\Externals\MarcaApi;
use App\Helpers\Url;
use App\Models\Marca;
use Throwable;

class MarcaSync
{
    public function run(string $marca): ?int
    {
        try {
            $marcaApi = MarcaApi::find(Url::extractId($marca), ReturnType::ARRAY);
            $marca = Marca::apiImport( $marcaApi);

            return $marca->id ?? null;
        } catch (Throwable) {
            return null;
        }
    }
}
