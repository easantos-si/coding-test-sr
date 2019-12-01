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
        foreach (getLojasMigrateUp() as $lojaMigate)
        {
            Schema::connection($lojaMigate->loja->base_dados_nome)->create('produtos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nome');
                $table->string('descricao')->nullable();
                $table->integer('quantidade')->default(0);
                $table->decimal('preco');
                $table->json('atributos');
                $table->timestamps();
            });
            $lojaMigate->processado = 1;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (getLojasMigrateDown() as $lojaMigate)
        {
            Schema::connection($lojaMigate->base_dados_nome)->dropIfExists('produtos');
            $lojaMigate->processado = 1;
        }
    }
}
