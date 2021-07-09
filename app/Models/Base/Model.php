<?php


namespace App\Models\Base;

use App\Exceptions\Model\ModelApiImportErrorException;
use App\Exceptions\Model\ModelImportErrorException;
use App\Exceptions\Model\ModelImportManyErrorException;
use App\Helpers\Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Class Model
 * @package App\Models\Base
 * @mixin Builder
 * @method static count()
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Importa um objeto
     * @param array $array
     * @return Model|$this
     * @throws ModelApiImportErrorException
     */
    public static function apiImport(array $array): Model | static
    {
        try{
            $model = new static();

            $toImport = collect($array)
                ->only($model->fillable)
                ->put('li_id', $array['id'] ?? null);

            return $model->updateOrCreate(
                $toImport->toArray(),
                $toImport->only('li_id')->toArray()
            );
        } catch (Throwable $exception) {
            throw new ModelApiImportErrorException(
                "Erro ao importar de api",
                Response::HTTP_BAD_REQUEST,
                $exception
            );
        }
    }

    /**
     * Importa vários objetos
     * @param array[] $arrays
     * @return Collection
     * @throws ModelImportManyErrorException
     */
    public static function apiImportMany(array $arrays): Collection
    {
        try {
            foreach ($arrays as $array) {
                $imported[] = self::apiImport($array);
            }

            return collect($imported ?? []);
        } catch (Throwable $t) {
            throw new ModelImportManyErrorException("Erro ao importação multipla", Response::HTTP_BAD_REQUEST, $t);
        }

    }

    /**
     * Importa os campos de um registro
     * @param array $items
     * @param array $fks
     * @return static
     * @throws ModelImportErrorException
     */
    public static function import(
        array $item,
        array $fks
    ): static {
        try {
            $model = new static();
            $fillable = $model->getFillable();

            $filledItem = Arr::merge($item, $fks);
            $fillableItem = Arr::only($filledItem, $fillable);

            return $model->firstOrCreate($fillableItem);
        } catch (Throwable $t) {
            throw new ModelImportErrorException("Erro ao importar os dados", Response::HTTP_BAD_REQUEST, $t);
        }
    }

    /**
     * Importa os campos de um registro
     * @param array $items
     * @param array $fks
     * @return Collection
     * @throws ModelImportManyErrorException
     */
    public static function importMany(
        array $items,
        array $fks
    ): Collection {
        try {
            foreach($items as $item) {
                $imported[] = self::import($item, $fks);
            }

            return collect($imported ?? []);
        } catch (Throwable $exception) {
            throw new ModelImportManyErrorException(
                "Erro ao importar os dados",
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $exception
            );
        }
    }
}
