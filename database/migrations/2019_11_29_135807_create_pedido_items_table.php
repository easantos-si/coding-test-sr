<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoItemsTable extends Migration
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
            Schema::connection($lojaMigate->loja->base_dados_nome)->create('pedido_items', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger( 'produto_id');
                $table->integer('quantidade');
                $table->decimal('preco');
                $table->timestamps();
            });
            $lojaMigate->processado = 1;
        }
    }
// lista de itens do pedido (produto, quantidade e preço);
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (getLojasMigrateDown() as $lojaMigate)
        {
            Schema::connection($lojaMigate->loja->base_dados_nome)->dropIfExists('pedido_items');
            $lojaMigate->processado = 1;
        }
    }
}
