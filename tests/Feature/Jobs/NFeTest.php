<?php

namespace Tests\Feature\Jobs;

use App\Jobs\MakeNFeJob;
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
        Pedido::factory()
            ->hasItens(['quantidade' => 2])
            ->create();

        $expectedPedidos = MakeNFeJob::dispatchSync(Pedido::first()->id);

        $this->assertEquals($expectedPedidos, Pedido::count());
    }
}
