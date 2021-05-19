<?php


namespace App\Services\Sync;


use App\Externals\MarcaApi;
use App\Helpers\Arr;
use App\Helpers\Url;
use App\Models\Marca;
use Throwable;

class MarcaSync
{
    public function __construct(private Marca $marca) {}

    public function run(string $marca): ?int
    {
        try {
            $marcaApi = MarcaApi::find(Url::extractId($marca));

            $marca = $this->marca->updateOrCreate(
                Arr::only($marcaApi, $this->marca->getFillable()),
                ['li_id' => $marcaApi['id'] ?? null]
            );

            return $marca->id ?? null;
        } catch (Throwable) {
            return null;
        }
    }
}
