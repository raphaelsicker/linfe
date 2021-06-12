<?php


namespace App\Services\Sync;


use App\Enums\ReturnType;
use App\Externals\GradeApi;
use App\Helpers\Arr;
use App\Helpers\Url;
use App\Models\Grade;
use App\Models\Variacao;

class VariacaoSync
{
    public function run(array $variacoes): array
    {
        foreach ($variacoes as $variacaoUrl) {
            $gradeApiId = Url::extractParentId($variacaoUrl);
            $gradeApi = GradeApi::find($gradeApiId, ReturnType::ARRAY);

            $grade = Grade::apiImport($gradeApi);
            $variacoesApi = Arr::addFk($gradeApi['variacoes'], 'grade_id', $grade->id);

            Variacao::apiImportMany($variacoesApi);
            $variacoesIds[] = $this->getCurrentVariacaoId($variacaoUrl ?? '');
        }

        return $variacoesIds ?? [];
    }

    /**
     * @param string $variacaoUrl
     * @return int|null
     */
    private function getCurrentVariacaoId(string $variacaoUrl): ?int
    {
        $variacaoApiId = Url::extractId($variacaoUrl ?? '');

        $variacao = Variacao::where([
            'li_id' => $variacaoApiId
        ])->first();

        return $variacao->id ?? null;
    }
}
