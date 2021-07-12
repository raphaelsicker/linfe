<?php

namespace Tests\Feature\Jobs;

use App\Jobs\MakeNFeJob;
use App\Models\Cidade;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class NFeTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testDispatchSendNFe()
    {
        Queue::fake();
        Queue::assertNothingPushed();

        MakeNFeJob::dispatch();
        Queue::assertPushed(MakeNFeJob::class);
    }

    public function testMakeNFeJob()
    {
        $pedido = Pedido::factory()
            ->hasItens(['quantidade' => 2])
            ->create();

        $expectedPedidos = MakeNFeJob::dispatchSync();
        $this->assertEquals($expectedPedidos, Pedido::count());
    }
}
