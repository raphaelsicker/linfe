<?php

namespace Tests\Feature\Jobs;

use App\Jobs\PedidoSyncJob;
use App\Models\Pedido;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PedidoSyncTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testDispatchPedidoSync()
    {
        Queue::fake();
        Queue::assertNothingPushed();

        PedidoSyncJob::dispatch();
        Queue::assertPushed(PedidoSyncJob::class);
    }

    public function testPedidoSyncJob()
    {
        $expectedPedidos = PedidoSyncJob::dispatchSync();
        $this->assertEquals($expectedPedidos, Pedido::count());
    }
}
