<?php


namespace App\Services\NFe;


use App\Enums\Country;
use App\Enums\NFeAmbType;
use App\Enums\NFeCRTType;
use App\Enums\NFeDANFeType;
use App\Enums\NFeDestType;
use App\Enums\NFeEmisType;
use App\Enums\NFeFinType;
use App\Enums\NFeIndFinalType;
use App\Enums\NFeIndIEDestType;
use App\Enums\NFeIndTotType;
use App\Enums\NFeModType;
use App\Enums\NFeNatOpType;
use App\Enums\NFeIndPresType;
use App\Enums\NFeOpType;
use App\Enums\NFeProcEmiType;
use App\Enums\NFeProductUnityType;
use App\Helpers\Arr;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Models\PedidoItem;
use Carbon\Carbon;
use NFePHP\NFe\Make;

class NFeMaker
{
    private Pedido $pedido;

    public function __construct(private Make $make) {}

    public function getXML(Pedido $pedido): ?string
    {
        $this->pedido = $pedido;
        $nfe = $this->make;

        $nfe->taginfNFe((object) ['versao' => '4.00']);
        $nfe->tagide($this->getTagIde());
        $nfe->tagemit($this->getTagEmit());
        $nfe->tagenderEmit($this->getTagEnderEmit());
        $nfe->tagdest($this->getTagDest());
        $nfe->tagenderDest($this->getTagEnderDest());

        /** @var PedidoItem $item */
        foreach($this->pedido->itens as $key => $item) {
            $itemId = $key + 1;
            $nfe->tagprod($this->getTagProd($itemId, $item));
        }

        $nfe->tagtransp((object) ['modFrete' => $this->pedido->modFrete()]);
        $nfe->tagtransporta($this->getTagTransportadora());
        // $nfe->tagvol($this->getTagVol());

        return $nfe->getXML();
    }

    /**
     * Identificação da Nota Fiscal eletrônica
     * @return object
     */
    private function getTagIde(): object
    {
        $empresa = $this->pedido->empresa;

        return Arr::toObject([
            'cUF' => $empresa?->endereco?->cidade?->estado?->ibge, // Código da UF do emitente do Documento Fiscal
            'cNF' => $this->pedido->id, //Código Numérico que compõe a Chave de Acesso
            'natOp' => NFeNatOpType::SALE, // Descrição da Natureza da Operação
            'mod' => NFeModType::NFE, // Código do Modelo do Documento Fiscal
            'serie' => 1, // Série do Documento Fiscal
            'nNF' => $this->pedido->id + 10000000, // Número do Documento Fiscal
            'dhEmi' => Carbon::now('-03:00')->toAtomString(), // Data e hora de emissão do Documento Fiscal (AAAA-MM-DDThh:mm:ssTZD)
            'dhSaiEnt' => null, // Data e hora de Saída ou da Entrada da Mercadoria/Produto (AAAA-MM-DDThh:mm:ssTZD)
            'tpNF' => NFeOpType::OUTPUT, // Tipo de Operação
            'idDest' => NFeDestType::INTERNAL, // Identificador de local de destino da operação
            'cMunFG' => $empresa?->endereco?->cidade?->ibge, // Código do Município de Ocorrência do Fato Gerador
            'tpImp' => NFeDANFeType::NORMAL_PORTRAIT, // Formato de Impressão do DANFE
            'tpEmis' => NFeEmisType::NORMAL, // Tipo de Emissão da NF-e
            'cDV' => 2, // Dígito Verificador da Chave deAcesso da NF-e
            'tpAmb' => NFeAmbType::HOMOLOG, // Identificação do Ambiente
            'finNFe' => NFeFinType::NORMAL, // Finalidade de emissão da NF-e
            'indFinal' => NFeIndFinalType::FINAL, // Indica operação com Consumidor final
            'indPres' => NFeIndPresType::INTERNET, // Indicador de presença do comprador no estabelecimento comercial no momento da operação
            'indIntermed' => null, //usar a partir de 05/04/2021
            'procEmi' => NFeProcEmiType::OWN_APP, // Processo de emissão da NF-e
            'verProc' => env('APP_VERSION'), // Versão do Processo de emissão da NF-e
            'dhCont' => null, // Data e Hora da entrada em contingência (AAAA-MM-DDThh:mm:ssTZD)
            'xJust' => null, // Justificativa da entrada em contingência
        ]);
    }

    private function getTagEmit(): object
    {
        $empresa = $this->pedido->empresa;

        return Arr::toObject([
            'xNome' => $empresa->razao_social ?? $empresa->nome, // Razão Social ou Nome do emitente
            'xFant' => $empresa->nome, // Nome fantasia
            'IE' => $empresa->ie() ?? "ISENTO", // Inscrição Estadual do Emitente
            'IM' => $empresa->im() ?? null, // Inscrição Municipal do Prestador de Serviço
            'CNAE' => $empresa->im() ? $empresa->cnae() : null, // CNAE fiscal
            'CRT' => NFeCRTType::SIMPLE, // Código de Regime Tributário
            'CNPJ' => $empresa->cnpj(), // CNPJ do emitente
        ]);
    }

    private function getTagEnderEmit(): object
    {
        $empresa = $this->pedido->empresa;

        return $this->getTagEnder(
            $empresa->endereco,
            $empresa->comercial->numero ?? $empresa->telefones()->first()->numero
        );
    }

    private function getTagDest(): object
    {
        $cliente = $this->pedido->cliente;

        return Arr::toObject([
            'xNome' => $cliente->razao_social ?? $cliente->nome, // Razão Social ou Nome do emitente
            'CPF' => $cliente->cpf(), // CNPJ do emitente
            'email' => $cliente->emailPessoal(), // Email
            'indIEDest' => NFeIndIEDestType::EXEMPT, // Indicador da IE do Destinatário
            'IE' => $cliente->ie() ?? "ISENTO", // Inscrição Estadual do Emitente
            'IM' => $cliente->im() ?? null, // Inscrição Municipal do Prestador de Serviço
            'CNAE' => $cliente->im() ? $cliente->cnae() : null, // CNAE fiscal
            'CRT' => NFeCRTType::SIMPLE, // Código de Regime Tributário
        ]);
    }

    private function getTagEnderDest(): object
    {
        $cliente = $this->pedido->cliente;

        return $this->getTagEnder(
            $cliente->endereco,
            $cliente->celular->numero ?? $cliente->telefones()->first()->numero
        );
    }

    /**
     * @param Endereco $endereco
     * @param string $telefone
     * @return object
     */
    private function getTagEnder(
        Endereco $endereco,
        string $telefone
    ): object {
        return Arr::toObject([
            'xLgr' => $endereco->endereco, // Logradouro
            'nro' => $endereco->numero, // Número
            'xCpl' => $endereco->complemento, // Complemento
            'xBairro' => $endereco->bairro, // Bairro
            'cMun' => $endereco->cidade->ibge, // Código do Município
            'xMun' => $endereco->cidade->nome, // Nome do Município
            'UF' => $endereco->cidade->estado->uf, // Sigla da UF
            'CEP' => $endereco->cep, // Código do CEP
            'cPais' => Country::BRASIL, // Código do País
            'xPais' => Country::find(Country::BRASIL), // Nome do País
            'fone' => $telefone, // Telefone
        ]);
    }

    private function getTagProd(
        int $itemId,
        PedidoItem $item
    ): object {
        return Arr::toObject([
            'item' => $itemId, //item da NFe
            'cProd' => $item->produto->sku, // Código do produto ou serviço
            'cEAN' => null, // GTIN (Global Trade Item Number) do produto, antigo código EAN ou código de barras
            'xProd' => $item->nome, // Descrição do produto ou serviço
            'NCM' => $item->ncm, // Código NCM com 8 dígitos
            'cBenef' => null, //incluído no layout 4.00
            'EXTIPI' => '', //
            'CFOP' => '', // Código Fiscal de Operações e Prestações
            'uCom' => NFeProductUnityType::UN, // Unidade Comercial
            'qCom' => $item->quantidade, // Quantidade Comercial
            'vUnCom' => $item->precoVenda(), // Valor Unitário de Comercialização
            'vProd' => $item->quantidade * $item->precoVenda(), // Valor Total Bruto dos Produtos ou Serviços
            'cEANTrib' => null, // GTIN (Global Trade Item Number) da unidade tributável, antigo código EAN ou código de barras
            'uTrib' => NFeProductUnityType::UN, // Unidade Tributável
            'qTrib' => $item->quantidade, // Quantidade Tributável
            'vUnTrib' => $item->precoVenda(), // Valor Unitário de tributação
            'indTot' => NFeIndTotType::YES, // Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)
            'xPed' => $item->pedido->id, // Número do Pedido de Compra
            'nItemPed' => $item->id, // Item do Pedido de Compra
            'nFCI' => '', // Número de controle da FCI -Ficha de Conteúdo de Importação
        ]);
    }

    private function getTagTransportadora(): object
    {
        $transportadora =  $this->pedido->transportadora;

        return Arr::toObject([
            'xNome' => $transportadora->nome, // Razão Social ou nome
            'IE' => $transportadora->ie() ?? "ISENTO", // Inscrição Estadual do Transportador
            'xEnder' => $transportadora->endereco->completo(), // Endereço Completo
            'xMun' => $transportadora->endereco->cidade->nome, // Nome do município
            'UF' => $transportadora->endereco->cidade->estado->uf, // Sigla da UF
            'CNPJ' => $transportadora->cnpj(), // CNPJ do Transportador
        ]);
    }

    private function getTagVol(): object
    {
        return Arr::toObject([

        ]);
    }


}
