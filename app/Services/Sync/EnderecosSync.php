<?php


namespace App\Services\Sync;


use App\Exceptions\Endereco\EnderecoImportErrorException;
use App\Exceptions\Model\ModelImportErrorException;
use App\Helpers\Obj;
use App\Models\Cidade;
use App\Models\Endereco;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Throwable;

class EnderecosSync
{
    /**
     * @param iterable $enderecosApi
     * @param int $clienteId
     * @return Collection
     * @throws EnderecoImportErrorException
     */
    public function run(
        iterable $enderecosApi,
        int $clienteId
    ): Collection {
        try {
            foreach ($enderecosApi as $endereco) {
                $endereco->cidade_id = $this->getCidadeId(
                    $endereco->cidade,
                    $endereco->estado
                );
                $enderecos[] = Obj::toArray($endereco);
            }

            return Endereco::importMany($enderecos, ['pessoa_id' => $clienteId]);
        } catch (Throwable $exception) {
            throw new EnderecoImportErrorException(
                "Erro ao criar a Entrega",
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $exception
            );
        }
    }

    /**
     * @param string $cidade
     * @param string $estado
     * @return int|null
     */
    private function getCidadeId(
        string $cidade,
        string $estado
    ): ?int {
        return Cidade::join('estados', 'estado_id', 'estados.id')
            ->where('cidades.nome', $cidade)
            ->where('uf', $estado)
            ->first('cidades.*')
            ->id ?? null;
    }
}
