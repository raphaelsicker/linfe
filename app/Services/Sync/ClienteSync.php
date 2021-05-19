<?php


namespace App\Services\Sync;


use App\Enums\DocumentType;
use App\Enums\EmailType;
use App\Enums\Gender;
use App\Enums\PhoneType;
use App\Externals\ClienteApi;
use App\Helpers\Arr;
use App\Models\Cidade;
use App\Models\Cliente;
use Throwable;

class ClienteSync
{
    /**
     * @param array $cliente
     * @return int|null
     */
    public function run(array $cliente): ?int
    {
        try {
            if(!$clienteId = $cliente['id'] ?? false) {
                return null;
            }

            $clienteApi = ClienteApi::find($clienteId);

            $cliente = Cliente::updateOrCreate([
                'nome' => $clienteApi['nome'],
                'razao_social' => $clienteApi['razao_social'],
                'data_nascimento' => $clienteApi['data_nascimento'],
                'sexo' => $clienteApi['sexo'] ?: Gender::OTHERS,
                'li_id' => $clienteId,
                'tipo_de_pessoa' => strtolower($clienteApi['tipo'])
            ], ['li_id' => $clienteId]);

            $cliente->documentos()->createMany($this->getDocs($clienteApi));
            $cliente->telefones()->createMany($this->getPhones($clienteApi));
            $cliente->emails()->createMany($this->getEmails($clienteApi));
            $cliente->enderecos()->createMany($this->getAddress($clienteApi));

            return $cliente->id ?? null;
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @param array $clienteApi
     * @return array[]
     */
    private function getDocs(array $clienteApi): array
    {
        $docs = [
            [
                'tipo' => DocumentType::CPF,
                'documento' => $clienteApi['cpf']
            ], [
                'tipo' => DocumentType::CNPJ,
                'documento' => $clienteApi['cnpj']
            ], [
                'tipo' => DocumentType::RG,
                'documento' => $clienteApi['rg']
            ],
        ];

        return Arr::havingKey($docs, 'documento');
    }

    private function getPhones(array $clienteApi): array
    {
        $phones = [
            [
                'tipo' => PhoneType::LANDLINE,
                'numero' => $clienteApi['telefone_principal']
            ], [
                'tipo' => PhoneType::CELL,
                'numero' => $clienteApi['telefone_celular']
            ], [
                'tipo' => PhoneType::COMMERCIAL,
                'numero' => $clienteApi['telefone_comercial']
            ],
        ];

        return Arr::havingKey($phones, 'numero');
    }

    private function getEmails(array $clienteApi): array
    {
        $emails = [
            [
                'tipo' => EmailType::PERSONAL,
                'email' => $clienteApi['email']
            ]
        ];

        return Arr::havingKey($emails, 'email') ?? [];
    }

    private function getAddress(array $clienteApi): array
    {
        foreach ($clienteApi['enderecos'] as &$endereco) {
            $endereco['cidade_id'] = $this->getCidadeId(
                $endereco['cidade'],
                $endereco['estado']
            );
        }

        return $clienteApi['enderecos'] ?? [];
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
