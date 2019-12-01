<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLojaMigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loja_migrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigIncrements('loja_id');
            $table->boolean('migration');
            $table->boolean('rollback');
            $table->boolean('processado');
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
        Schema::dropIfExists('loja_migrations');
    }
}
