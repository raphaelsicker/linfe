<?php

namespace App\Jobs;

use App\Exceptions\Pedido\PedidoImportErrorException;
use App\Jobs\Base\Job;
use App\Services\Sync\PedidoSync;
use Carbon\Carbon;

class PedidoSyncJob extends Job
{
    private ?string $since;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $since = null)
    {
        $this->since = $since;
    }

    /**
     * Execute the job.
     *
     * @param PedidoSync $pedidoSync
     * @return int
     * @throws PedidoImportErrorException
     */
    public function handle(PedidoSync $pedidoSync)
    {
        return $pedidoSync->run(
            $this->since
                ? Carbon::tz('-03:00')->from($this->since)
                : Carbon::now('-03:00')->subDay()
        );
    }
}
