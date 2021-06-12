<?php


namespace App\Services\Sync;


use App\Enums\PriceType;
use App\Exceptions\Produto\ProdutoImportErrorException;
use App\Externals\ProdutoApi;
use App\Helpers\Arr;
use App\Helpers\Obj;
use App\Helpers\Url;
use App\Models\Produto;
use App\Models\ProdutoPreco;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Throwable;

class ProdutoSync
{
    public function __construct(
        private MarcaSync $marcaSync,
        private VariacaoSync $variacaoSync
    ) {}

    /**
     * @param object $item
     * @return array
     * @throws ProdutoImportErrorException
     */
    public function run(object $item): array
    {
        try {
            $produtoApi = ProdutoApi::find(Url::extractId($item->produto ?? ''));
            $produtoPaiApi = ProdutoApi::find(Url::extractId($item->produto_pai ?? ''));
            $variacoes = $this->variacaoSync->run($produtoApi->variacoes);

            $fullItem = Obj::mergeNotNull($item, $produtoPaiApi, $produtoApi);
            $fullItem->marca_id = $this->marcaSync->run($produtoPaiApi->marca ?? '')?->id;

            $produto = Produto::apiImport((array) $fullItem);
            $this->syncProdutoPreco($fullItem, $produto->id);

            return [
                'produto' => $produto,
                'variacoes' => $variacoes
            ];
        } catch (Throwable $t) {
            throw new ProdutoImportErrorException("Erro ao importar o Produto", Response::HTTP_BAD_REQUEST, $t);
        }
    }

    private function syncProdutoPreco(
        object $produto,
        int $produtoId
    ): Collection {
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

        return ProdutoPreco::importMany(
            Arr::havingKey($prices, 'valor'),
            ['produto_id' => $produtoId]
        );
    }

}
