<?php


namespace App\Services\Sincronizadores;


use App\Enums\Sexo;
use App\Enums\TipoDeDocumento;
use App\Enums\TipoDeEmail;
use App\Enums\TipoDePessoa;
use App\Enums\TipoDeTelefone;
use App\Externals\LiApiCliente;
use App\Models\Cidade;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;

class ClienteService
{
    private Cliente $cliente;
    private ?object $dados;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    public function sincronizar(int $clienteId): Cliente|Model
    {
        $this->atualizar($clienteId)
            ->cliente()
            ->documentos()
            ->telefones()
            ->emails()
            ->enderecos();

        return $this->clienteSalvo();
    }

    private function atualizar(int $clienteId): self
    {
        if($resposta = LiApiCliente::find($clienteId)) {
            $this->dados = $resposta?->object() ?? null;
        }

        return $this;
    }

    private function cliente(): self
    {
        $this->cliente = Cliente::create([
            'nome' => $this->dados->nome,
            'razao_social' => $this->dados->razao_social,
            'data_nascimento' => $this->dados->data_nascimento,
            'sexo' => $this->dados->sexo ?: Sexo::OUTROS,
            'li_id' => $this->dados->id,
            'tipo_de_pessoa' => strtolower($this->dados->tipo)
        ]);

        return $this;
    }

    private function documentos(): self
    {
        $this->criarDocumento(TipoDeDocumento::CPF, $this->dados->cpf ?? null);
        $this->criarDocumento(TipoDeDocumento::CNPJ, $this->dados->cnpj ?? null);
        $this->criarDocumento(TipoDeDocumento::RG, $this->dados->rg ?? null);

        return $this;
    }

    private function criarDocumento(string $tipo, ?string $documento): void
    {
        if($documento) {
            $this->cliente->documentos()->create([
                'tipo' => $tipo,
                'documento' => $documento,
            ]);
        }
    }

    private function telefones(): self
    {
        $this->criarTelefones(TipoDeTelefone::FIXO, $this->dados->telefone_principal);
        $this->criarTelefones(TipoDeTelefone::CELULAR, $this->dados->telefone_celular);
        $this->criarTelefones(TipoDeTelefone::COMERCIAL, $this->dados->telefone_comercial);

        return $this;
    }

    private function criarTelefones(string $tipo, ?string $numero)
    {
        if($numero) {
            $this->cliente->telefones()->create([
                'tipo' => $tipo,
                'numero' => $numero
            ]);
        }
    }

    private function emails(): self
    {
        if($this->dados->email) {
            $this->cliente->emails()->create( [
                'tipo' => TipoDeEmail::PESSOAL,
                'email' => $this->dados->email
            ]);
        }
        return $this;
    }

    private function enderecos(): self
    {
        foreach ($this->dados->enderecos as $endereco) {
            $cidade = $this->buscarCidade($endereco->cidade, $endereco->estado);

            $this->cliente->enderecos()->create([
                'principal' => $endereco->principal,
                'endereco' => $endereco->endereco,
                'numero' => $endereco->numero,
                'complemento' => $endereco->complemento,
                'bairro' => $endereco->bairro,
                'cep' => $endereco->cep,
                'cidade_id' => $cidade->id,
                'referencia' => $endereco->referencia,
            ]);
        }
    }

    private function buscarCidade(string $cidade, string $estado): ?Cidade
    {
        return Cidade::join('estados', 'estado_id', 'estados.id')
            ->where('cidades.nome', $cidade)
            ->where('uf', $estado)
            ->first('cidades.*');
    }

    private function clienteSalvo(): Cliente | Model
    {
        return Cliente::with([
            'documentos',
            'emails',
            'telefones',
            'enderecos'
        ])->find($this->cliente->id ?? null);
    }
}
