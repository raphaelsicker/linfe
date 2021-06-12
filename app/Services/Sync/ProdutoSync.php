<?php


namespace App\Services\Sync;


use App\Enums\PriceType;
use App\Externals\ProdutoApi;
use App\Helpers\Arr;
use App\Helpers\Obj;
use App\Helpers\Url;
use App\Models\Produto;
use App\Models\ProdutoPreco;

class ProdutoSync
{
    public function __construct(
        private MarcaSync $marcaSync,
        private VariacaoSync $variacaoSync
    ) {}

    public function run(object $item): array
    {
        $produtoApi = ProdutoApi::find(Url::extractId($item->produto ?? ''));
        $produtoPaiApi = ProdutoApi::find(Url::extractId($item->produto_pai ?? ''));
        $variacoes = $this->variacaoSync->run($produtoApi->variacoes);

        $fullItem = Obj::mergeNotNull($item, $produtoPaiApi, $produtoApi);
        $fullItem->marca_id = $this->marcaSync->run($produtoPaiApi->marca ?? '');

        $produto = Produto::apiImport((array) $fullItem);
        $this->syncProdutoPreco($fullItem, $produto->id);

        return [$produto->id ?? null, $variacoes];
    }

    private function syncProdutoPreco(
        object $produto,
        int $produtoId
    ): bool {
        $prices = [
            [
                'tipo' => PriceType::COST,
                'valor' => $produto->preco_custo ?? null
            ], [
                'tipo' => PriceType::FULL,
                'valor' => $produto->preco_cheio ?? null
            ], [
                'tipo' => PriceType::PROMOTIONAL,
                'valor' => $produto->preco_promocional ?? null
            ], [
                'tipo' => PriceType::SALE,
                'valor' => $produto->preco_venda ?? null
            ],
        ];

        return ProdutoPreco::import(
            Arr::havingKey($prices, 'valor'),
            ['produto_id' => $produtoId]
        );
    }

}
