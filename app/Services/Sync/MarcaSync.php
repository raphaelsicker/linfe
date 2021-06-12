<?php


namespace App\Services\Sync;


use App\Enums\ReturnType;
use App\Exceptions\Marca\MarcaImportErrorException;
use App\Externals\MarcaApi;
use App\Helpers\Url;
use App\Models\Marca;
use Illuminate\Http\Response;
use Throwable;

class MarcaSync
{
    /**
     * @param string $marca
     * @return Marca
     * @throws MarcaImportErrorException
     */
    public function run(string $marca): Marca
    {
        try {
            $marcaApi = MarcaApi::find(Url::extractId($marca), ReturnType::ARRAY);
            return Marca::apiImport( $marcaApi);
        } catch (Throwable $t) {
            throw new MarcaImportErrorException("Erro ao importar Marca", Response::HTTP_BAD_REQUEST, $t);
        }
    }
}
