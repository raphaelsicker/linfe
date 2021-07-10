<?php


namespace App\Services\Sync;


use App\Enums\ReturnType;
use App\Exceptions\Situacao\SituacaoImportErrorException;
use App\Externals\SituacaoApi;
use App\Models\Situacao;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Throwable;

class SituacaoSync
{
    /**
     * @return Collection
     * @throws SituacaoImportErrorException
     */
    public function run(): Collection
    {
        try {
            $situacoesApi = SituacaoApi::get([], ReturnType::ARRAY);

            return Situacao::apiImportMany( $situacoesApi);
        } catch (Throwable $exception) {
            throw new SituacaoImportErrorException(
                "Erro ao importar Situações",
                Response::HTTP_BAD_REQUEST,
                $exception
            );
        }
    }
}
