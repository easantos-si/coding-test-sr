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
        if(!isDatabaseDefault())
        {
            Schema::create('funcionarios', function (Blueprint $table) {
                $table->engine = 'innoDB';
                $table->bigIncrements('id');
                $table->string('name',200);
                $table->string('email',100)->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->boolean('ativo')->default(1);
                $table->rememberToken();
                $table->timestamps();

                $table->index([DB::raw('name(20)')], 'funcionarios_name_index');
                $table->index([DB::raw('email(15)')], 'funcionarios_email_index');
                $table->index(['ativo'], 'funcionarios_ativo_index');
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
            Schema::dropIfExists('funcionarios');
        }
    }
}
