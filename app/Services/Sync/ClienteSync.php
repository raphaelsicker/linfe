<?php


namespace App\Services\Sync;


use App\Enums\DocumentType;
use App\Enums\EmailType;
use App\Enums\Gender;
use App\Enums\PhoneType;
use App\Exceptions\Cliente\ClienteNotCreatedException;
use App\Exceptions\Cliente\ClienteNotFoundException;
use App\Exceptions\Model\ModelImportErrorException;
use App\Exceptions\Model\ModelImportManyErrorException;
use App\Externals\ClienteApi;
use App\Helpers\Arr;
use App\Helpers\Str;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Email;
use App\Models\Telefone;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Throwable;

class ClienteSync
{
    public function __construct(private EnderecosSync $enderecosSync) {}

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
            $this->enderecosSync->run($clienteApi->enderecos, $cliente->id);

            return $cliente;
        } catch (Throwable $t) {
            throw new ClienteNotCreatedException("Erro ao importar o cliente", Response::HTTP_BAD_REQUEST, $t);
        }
    }

    /**
     * @param object $clienteApi
     * @param int $clienteId
     * @return Collection
     * @throws ModelImportManyErrorException
     */
    private function syncDocs(
        object $clienteApi,
        int $clienteId
    ): Collection {
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

        return Documento::importMany(
            Arr::havingKey($docs, 'documento'),
            ['pessoa_id' => $clienteId]
        );
    }

    /**
     * @param object $clienteApi
     * @param int $clienteId
     * @return Collection
     * @throws ModelImportManyErrorException
     */
    private function syncPhones(
        object $clienteApi,
        int $clienteId
    ): Collection {
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

        return Telefone::importMany(
            Arr::havingKey($phones, 'numero'),
            ['pessoa_id' => $clienteId]
        );
    }

    /**
     * @param object $clienteApi
     * @param int $clienteId
     * @return Collection
     * @throws ModelImportManyErrorException
     */
    private function syncEmails(
        object $clienteApi,
        int $clienteId
    ): Collection {
        $emails = [
            [
                'tipo' => EmailType::PERSONAL,
                'email' => $clienteApi->email
            ]
        ];

        return Email::importMany(
            Arr::havingKey($emails, 'email'),
            ['pessoa_id' => $clienteId]
        );
    }
}
