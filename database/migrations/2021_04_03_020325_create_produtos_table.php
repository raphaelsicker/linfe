<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('apelido')->nullable();
            $table->string('descricao_completa');
            $table->boolean('ativo')->default(true);
            $table->boolean('bloqueado')->default(false);
            $table->boolean('removido')->default(false);
            $table->boolean('destaque')->default(false);
            $table->boolean('usado')->default(false);
            $table->foreignId('marca_id');
            $table->bigInteger('pai_id')->nullable();
            $table->integer('altura')->nullable();
            $table->integer('largura')->nullable();
            $table->integer('profundidade')->nullable();
            $table->decimal('peso')->nullable();
            $table->string('ncm');
            $table->string('sku');
            $table->bigInteger('li_id')->nullable();

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
        Schema::dropIfExists('produtos');
    }
}
