<?php

namespace App\Jobs;

use App\Exceptions\Pedido\PedidoImportErrorException;
use App\Jobs\Base\Job;
use App\Services\Sync\PedidoSync;
use Carbon\Carbon;

class SendNFeJob extends Job
{
    private array $ids;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $ids = [])
    {
        $this->ids = $ids;
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
        return true;
    }
}
