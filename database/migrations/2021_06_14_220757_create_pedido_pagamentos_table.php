<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->nullable();
            $table->decimal('valor');
            $table->decimal('valor_pago');
            $table->integer('numero_de_parcelas')->nullable();
            $table->decimal('valor_das_parcelas')->nullable();
            $table->bigInteger('li_id')->nullable();

            $table->foreignId('forma_id')->constrained('forma_de_pagamentos');
            $table->foreignId('pedido_id')->constrained();

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
        Schema::dropIfExists('pedido_pagamentos');
    }
}
