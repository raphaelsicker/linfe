<?php


namespace App\Models\Base;

use App\Helpers\Arr;
use Illuminate\Database\Eloquent\Builder;
use Throwable;

/**
 * Class Model
 * @package App\Models\Base
 * @mixin Builder
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Importa um objeto
     * @param array $array
     * @return Model|$this
     */
    public static function apiImport(array $array): Model | static
    {
        $model = new static();
        $toImport = collect($array)
            ->only($model->fillable)
            ->put('li_id', $array['id'] ?? null);

        return $model->updateOrCreate(
            $toImport->toArray(),
            $toImport->only('li_id')->toArray()
        );
    }

    /**
     * Importa vários objetos
     * @param array[] $arrays
     * @return bool
     */
    public static function apiImportMany(array $arrays): bool
    {
        try {
            foreach ($arrays as $array) {
                self::apiImport($array);
            }

            return true;
        } catch (Throwable) {
            return false;
        }

    }

    public static function import(
        array $items,
        array $fks
    ): bool {
        try {
            $model = new static();
            $fillable = $model->getFillable();

            foreach($items as $item) {
                $filledItem = Arr::merge($item, $fks);
                $fillableItem = Arr::only($filledItem, $fillable);
                $model->firstOrCreate($fillableItem);
            }

            return true;
        } catch (Throwable $t) {
            return false;
        }
    }
}
