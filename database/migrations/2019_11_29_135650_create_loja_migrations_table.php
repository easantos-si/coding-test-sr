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
        if(isDatabaseDefault())
        {
            Schema::create('loja_migrations', function (Blueprint $table) {
                $table->engine = 'innoDB';
                $table->bigIncrements('id');
                $table->bigInteger('loja_id')->unsigned();
                $table->boolean('migration');
                $table->boolean('rollback');
                $table->boolean('processado');
                $table->timestamps();

                $table->index(['migration'], 'loja_migrations_migration_index');
                $table->index(['rollback'], 'loja_migrations_rollback_index');
                $table->index(['processado'], 'loja_migrations_processado_index');
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
            Schema::dropIfExists('loja_migrations');
        }
    }
}
