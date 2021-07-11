<?php

namespace App\Jobs;

use App\Exceptions\Pedido\PedidoImportErrorException;
use App\Jobs\Base\Job;
use App\Services\NFe\NFeMaker;
use App\Services\Sync\PedidoSync;
use Carbon\Carbon;

class MakeNFeJob extends Job
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
     */
    public function handle(NFeMaker $nfeMaker)
    {
        return $nfeMaker->run($this->ids);
    }
}
