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
        if(!isDatabaseDefault())
        {
            Schema::create('pedido_items', function (Blueprint $table) {
                $table->engine = 'innoDB';
                $table->bigIncrements('id');
                $table->bigInteger( 'pedido_id')->unsigned();
                $table->bigInteger( 'produto_id')->unsigned();
                $table->integer('quantidade');
                $table->decimal('preco');
                $table->timestamps();

                $table->index(['produto_id','quantidade'], 'pedido_items_index');
            });
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
        if(!isDatabaseDefault())
        {
            Schema::dropIfExists('pedido_items');
        }
    }
}
