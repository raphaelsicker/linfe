<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_itens', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('ncm');
            $table->integer('quantidade')->nullable();
            $table->integer('altura')->nullable();
            $table->integer('largura')->nullable();
            $table->integer('profundidade')->nullable();
            $table->decimal('peso')->nullable();
            $table->bigInteger('li_id')->nullable();

            $table->foreignId('pedido_id')->constrained();
            $table->foreignId('produto_id')->constrained();

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
        Schema::dropIfExists('pedido_itens');
    }
}
