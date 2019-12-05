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
                $table->string('name', 100)->unique();
                $table->string('password', 60);
                $table->string('base_dados_nome', 60)->unique();
                $table->boolean('ativo');
                $table->rememberToken();
                $table->string('passport', 10)->unique();
                $table->string('hash_loja', 60)->nullable()->unique();
                $table->timestamps();

                $table->index([DB::raw('name(10)')], 'lojas_name_index');
                $table->index([DB::raw('base_dados_nome(15)')], 'lojas_base_dados_nome_index');
                $table->index([DB::raw('hash_loja(10)')], 'lojas_hash_loja_index');
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
