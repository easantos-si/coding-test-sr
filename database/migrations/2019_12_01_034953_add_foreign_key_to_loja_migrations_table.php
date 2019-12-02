<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToLojaMigrationsTable extends Migration
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
            Schema::table('loja_migrations', function (Blueprint $table) {
                $table->foreign('loja_id', 'loja_migrations_loja_id_to_lojas_foreign')->references('id')->on('lojas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
            Schema::table('loja_migrations', function (Blueprint $table) {
                $table->dropForeign('loja_migrations_loja_id_to_lojas_foreign');
                $table->dropIndex('loja_migrations_loja_id_to_lojas_foreign');
            });
        }
    }
}
