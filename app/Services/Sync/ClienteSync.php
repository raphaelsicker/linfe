<?php


namespace App\Services\Sync;


use App\Enums\DocumentType;
use App\Enums\EmailType;
use App\Enums\Gender;
use App\Enums\PhoneType;
use App\Exceptions\Cliente\ClienteNotCreatedException;
use App\Exceptions\Cliente\ClienteNotFoundException;
use App\Exceptions\Model\ModelImportErrorException;
use App\Externals\ClienteApi;
use App\Helpers\Arr;
use App\Helpers\Obj;
use App\Helpers\Str;
use App\Models\Cidade;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Email;
use App\Models\Endereco;
use App\Models\Telefone;
use Illuminate\Http\Response;
use Throwable;

class ClienteSync
{
    /**
     * @param object $cliente
     * @return Cliente|null
     * @throws ClienteNotCreatedException
     */
    public function run(object $cliente): ?Cliente
    {
        try {
            if(!$clienteId = $cliente->id ?? false) {
                throw new ClienteNotFoundException("Cliente não encontrado");
            }

            $clienteApi = ClienteApi::find($clienteId);

            $cliente = Cliente::updateOrCreate([
                'nome' => $clienteApi->nome,
                'razao_social' => $clienteApi->razao_social,
                'data_nascimento' => $clienteApi->data_nascimento,
                'sexo' => $clienteApi->sexo ?: Gender::OTHERS,
                'li_id' => $clienteId,
                'tipo_de_pessoa' => Str::lower($clienteApi->tipo)
            ], ['li_id' => $clienteId]);

            $this->syncDocs($clienteApi, $cliente->id);
            $this->syncPhones($clienteApi, $cliente->id);
            $this->syncEmails($clienteApi, $cliente->id);
            $this->syncAddress($clienteApi, $cliente->id);

            return $cliente;
        } catch (Throwable $t) {
            throw new ClienteNotCreatedException("Erro ao importar o cliente", Response::HTTP_BAD_REQUEST, $t);
        }
    }

    /**
     * @param object $clienteApi
     * @param int $clienteId
     * @return Documento
     * @throws ModelImportErrorException
     */
    private function syncDocs(
        object $clienteApi,
        int $clienteId
    ): Documento {
        $docs = [
            [
                'tipo' => DocumentType::CPF,
                'documento' => $clienteApi->cpf
            ], [
                'tipo' => DocumentType::CNPJ,
                'documento' => $clienteApi->cnpj
            ], [
                'tipo' => DocumentType::RG,
                'documento' => $clienteApi->rg
            ],
        ];

        return Documento::import(
            Arr::havingKey($docs, 'documento'),
            ['pessoa_id' => $clienteId]
        );
    }

    /**
     * @param object $clienteApi
     * @param int $clienteId
     * @return Telefone
     * @throws ModelImportErrorException
     */
    private function syncPhones(
        object $clienteApi,
        int $clienteId
    ): Telefone {
        $phones = [
            [
                'tipo' => PhoneType::LANDLINE,
                'numero' => $clienteApi->telefone_principal
            ], [
                'tipo' => PhoneType::CELL,
                'numero' => $clienteApi->telefone_celular
            ], [
                'tipo' => PhoneType::COMMERCIAL,
                'numero' => $clienteApi->telefone_comercial
            ],
        ];

        return Telefone::import(
            Arr::havingKey($phones, 'numero'),
            ['pessoa_id' => $clienteId]
        );
    }

    /**
     * @param object $clienteApi
     * @param int $clienteId
     * @return Email
     * @throws ModelImportErrorException
     */
    private function syncEmails(
        object $clienteApi,
        int $clienteId
    ): Email {
        $emails = [
            [
                'tipo' => EmailType::PERSONAL,
                'email' => $clienteApi->email
            ]
        ];

        return Email::import(
            Arr::havingKey($emails, 'email'),
            ['pessoa_id' => $clienteId]
        );
    }

    /**
     * @param object $clienteApi
     * @param int $clienteId
     * @return Endereco
     * @throws ModelImportErrorException
     */
    private function syncAddress(
        object $clienteApi,
        int $clienteId
    ): Endereco {
        foreach ($clienteApi->enderecos as $endereco) {
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
