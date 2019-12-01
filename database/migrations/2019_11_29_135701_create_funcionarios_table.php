<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosTable extends Migration
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
            Schema::connection($lojaMigate->loja->base_dados_nome)->create('funcionarios', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nome');
                $table->string('email')->unique();
                $table->timestamp('email_data_validacao')->nullable();
                $table->string('senha');
                $table->boolean('ativo');
                $table->rememberToken();
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
            Schema::connection($lojaMigate->loja->base_dados_nome)->dropIfExists('funcionarios');
            $lojaMigate->processado = 1;
        }
    }
}
