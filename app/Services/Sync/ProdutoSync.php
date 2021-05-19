<?php


namespace App\Services\Sync;


use App\Externals\ProdutoApi;
use App\Helpers\Arr;
use App\Helpers\Url;
use App\Models\Produto;

class ProdutoSync
{
    public function __construct(
        private MarcaSync $marcaSync,
        private Produto $produto
    ) {}

    public function run(array $item): array
    {
        $produtoApi = ProdutoApi::find(Url::extractId($item['produto'] ?? ''));
        $produtoPaiApi = ProdutoApi::find(Url::extractId($item['produto_pai'] ?? ''));

        $produto = Arr::mergeNotNull(
            $item,
            $produtoPaiApi,
            $produtoApi,
            ['marca_id' => $this->marcaSync->run($produtoPaiApi['marca'] ?? '')]
        );

        $produto = $this->storeProduto($produto);
        return $items ?? [];
    }

    private function storeProduto(array $produto): ?Produto
    {
        return $this->produto->updateOrCreate([
            'nome' => $produtoPaiApi['nome'],
            'apelido',
            'descricao_completa',

            'ativo',
            'bloqueado',
            'removido',

            'destaque',
            'usado',
            'marca_id',
            'pai_id',

            'altura',
            'largura',
            'peso',
            'profundidade',

            'ncm',
            'gtin',
            'mpn',
            'sku',
            'tipo',
        ]);
    }

}
