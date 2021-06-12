<?php


namespace App\Services\Sync;


use App\Enums\ReturnType;
use App\Exceptions\Variacao\VariacaoImportErrorException;
use App\Exceptions\Variacao\VariacaoNotFoundException;
use App\Externals\GradeApi;
use App\Helpers\Arr;
use App\Helpers\Url;
use App\Models\Grade;
use App\Models\Variacao;
use Illuminate\Http\Response;
use Throwable;

class VariacaoSync
{
    /**
     * @param array $variacoes
     * @return array
     * @throws VariacaoImportErrorException
     */
    public function run(array $variacoes): array
    {
        try {
            foreach ($variacoes as $variacaoUrl) {
                $gradeApiId = Url::extractParentId($variacaoUrl);
                $gradeApi = GradeApi::find($gradeApiId, ReturnType::ARRAY);

                $grade = Grade::apiImport($gradeApi);
                $variacoesApi = Arr::addFk($gradeApi['variacoes'], 'grade_id', $grade->id);

                Variacao::apiImportMany($variacoesApi);
                $currentVariacoes[] = $this->getCurrentVariacaoId($variacaoUrl ?? '');
            }

            return $currentVariacoes ?? [];
        } catch (Throwable $t) {
            throw new VariacaoImportErrorException("Erro ao importar a variação", Response::HTTP_BAD_REQUEST, $t);
        }
    }

    /**
     * @param string $variacaoUrl
     * @return Variacao
     * @throws VariacaoNotFoundException
     */
    private function getCurrentVariacaoId(string $variacaoUrl): Variacao
    {
        try {
            $variacaoApiId = Url::extractId($variacaoUrl ?? '');
            return Variacao::where(['li_id' => $variacaoApiId])->first();
        } catch (Throwable $exception) {
            throw new VariacaoNotFoundException(
                "Não foi possível encontrar a variação",
                Response::HTTP_BAD_REQUEST,
                $exception
            );
        }
    }
}
