<?php


namespace App\Services\Sync;


use App\Enums\PriceType;
use App\Exceptions\Model\ModelImportManyErrorException;
use App\Exceptions\Pedido\PedidoNotCreatedException;
use App\Exceptions\PedidoItem\PedidoItemImportErrorException;
use App\Externals\ProdutoApi;
use App\Helpers\Arr;
use App\Helpers\Obj;
use App\Helpers\Url;
use App\Models\PedidoItem;
use App\Models\PedidoItemVariacao;
use App\Models\Produto;
use App\Models\ProdutoPreco;
use Illuminate\Http\Response;
use Throwable;

class PedidoItemSync
{
    public function __construct(
        private MarcaSync $marcaSync,
        private VariacaoSync $variacaoSync
    ) {}

    /**
     * @param object $item
     * @param int $pedidoId
     * @return void
     * @throws PedidoItemImportErrorException
     */
    public function run(object $item, int $pedidoId): void
    {
        try {
            $item = $this->fillFromApi($item);

            $item->pedido_id = $pedidoId;
            $item->marca_id = $this->marcaSync->run($item->marca ?? '')?->id;
            $item->produto_id = Produto::apiImport((array) $item)?->id;

            $this->syncProdutoPreco($item);
            $this->syncPedidoItem($item);
        } catch (Throwable $exception) {
            throw new PedidoItemImportErrorException(
                "Erro ao importar o Produto",
                Response::HTTP_BAD_REQUEST,
                $exception
            );
        }
    }

    /**
     * Completa os dados do item procurando na api
     * @param object $item
     * @return object
     */
    private function fillFromApi(object $item): object
    {
        return Obj::mergeNotNull(
            $item,
            ProdutoApi::find(Url::extractId($item->produto_pai ?? '')),
            ProdutoApi::find(Url::extractId($item->produto ?? ''))
        );
    }

    /**
     * @param object $item
     * @param int $produtoId
     * @return void
     * @throws ModelImportManyErrorException
     */
    private function syncProdutoPreco(object $item): void
    {
        $prices = [
            [
                'tipo' => PriceType::COST,
                'valor' => $item->preco_custo ?? null
            ], [
                'tipo' => PriceType::FULL,
                'valor' => $item->preco_cheio ?? null
            ], [
                'tipo' => PriceType::PROMOTIONAL,
                'valor' => $item->preco_promocional ?? null
            ], [
                'tipo' => PriceType::SALE,
                'valor' => $item->preco_venda ?? null
            ],
        ];

        ProdutoPreco::importMany(
            Arr::havingKey($prices, 'valor'),
            ['produto_id' => $item->produto_id]
        );
    }

    /**
     * @param object $item
     * @throws PedidoNotCreatedException
     */
    private function syncPedidoItem(object $item)
    {
        try {
            $variacoes = $this->variacaoSync->run($item->variacoes);
            $pedidoItem = PedidoItem::apiImport((array)$item);

            foreach ($variacoes as $variacao) {
                PedidoItemVariacao::import(
                    ['variacao_id' => $variacao->id],
                    ['pedido_item_id' => $pedidoItem->id]
                );
            }
        } catch (Throwable $exception) {
            throw new PedidoNotCreatedException(
                "Erro ao importar o item do Pedido",
                Response::HTTP_BAD_REQUEST,
                $exception
            );
        }
    }

}
