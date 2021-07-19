<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->text('cliente_obs')->nullable();
            $table->string('cupom_desconto')->nullable();

            $table->decimal('peso_real')->nullable();
            $table->decimal('valor_desconto')->nullable();
            $table->decimal('valor_envio')->nullable();
            $table->decimal('valor_subtotal');
            $table->decimal('valor_total');
            $table->bigInteger('li_id')->nullable();

            $table->foreignId('situacao_id')->constrained('situacoes');
            $table->foreignId('empresa_id')->constrained('pessoas');
            $table->foreignId('cliente_id')->constrained('pessoas');
            $table->foreignId('transportadora_id')->constrained('pessoas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
