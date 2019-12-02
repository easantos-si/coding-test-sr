<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLojasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(isDatabaseDefault())
        {
            Schema::create('lojas', function (Blueprint $table) {
                $table->engine = 'innoDB';
                $table->bigIncrements('id');
                $table->string('nome', 100)->unique();
                $table->string('senha', 60);
                $table->string('base_dados_nome', 60)->unique();
                $table->boolean('ativo');
                $table->rememberToken();
                $table->timestamps();

                $table->index([DB::raw('nome(10)')], 'lojas_nome_index');
                $table->index([DB::raw('base_dados_nome(15)')], 'lojas_base_dados_nome_index');
                $table->index(['ativo'], 'lojas_ativo_index');
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
        if(isDatabaseDefault())
        {
            Schema::dropIfExists('lojas');
        }
    }
}
