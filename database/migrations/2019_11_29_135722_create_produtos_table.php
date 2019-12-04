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
        if(!isDatabaseDefault())
        {
            Schema::create('produtos', function (Blueprint $table) {
                $table->engine = 'innoDB';
                $table->bigIncrements('id');
                $table->string('codigo',100)->unique();
                $table->string('nome',200);
                $table->string('descricao',500)->nullable();
                $table->integer('quantidade_estoque')->default(0);
                $table->decimal('preco')->default(0);
                $table->json('atributos');
                $table->timestamps();

                $table->index([DB::raw('codigo(50)')], 'produtos_codigo_index');
                $table->index([DB::raw('codigo(50)'),'quantidade_estoque'], 'produtos_codigo_quantidade_estoque_index');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(!isDatabaseDefault())
        {
            Schema::dropIfExists('produtos');
        }
    }
}
