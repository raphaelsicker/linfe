<?php

use App\Enums\Sexo;
use App\Enums\TipoDePessoa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('classe');
            $table->string('nome');
            $table->string('razao_social')->nullable();
            $table->string('data_nascimento')->nullable();
            $table->bigInteger('grupo_id')->nullable();
            $table->bigInteger('li_id')->nullable();
            $table->enum('tipo_de_pessoa', TipoDePessoa::keys());
            $table->enum('sexo', Sexo::keys())->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoas');
    }
}
