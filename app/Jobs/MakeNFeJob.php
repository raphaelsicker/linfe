<?php

namespace App\Jobs;

use App\Jobs\Base\Job;
use App\Models\Pedido;
use App\Services\NFe\NFeMaker;

class MakeNFeJob extends Job
{
    private int $id;

    /**
     * Create a new job instance.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @param NFeMaker $nfeMaker
     * @return string|null
     */
    public function handle(NFeMaker $nfeMaker): ?string
    {
        return $nfeMaker->getXML(Pedido::find($this->id));
    }
}
