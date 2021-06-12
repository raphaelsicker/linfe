<?php


namespace App\Services\Sync;


use App\Exceptions\Model\ModelImportErrorException;
use App\Helpers\Obj;
use App\Models\Cidade;
use App\Models\Endereco;

class EnderecosSync
{
    /**
     * @param object $enderecosApi
     * @param int $clienteId
     * @return Endereco
     * @throws ModelImportErrorException
     */
    public function run(
        object $enderecosApi,
        int $clienteId
    ): Endereco {
        foreach ($enderecosApi as $endereco) {
            $endereco->cidade_id = $this->getCidadeId(
                $endereco->cidade,
                $endereco->estado
            );
            $enderecos[] = Obj::toArray($endereco);
        }

        return Endereco::import($enderecos, ['pessoa_id' => $clienteId]);
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
