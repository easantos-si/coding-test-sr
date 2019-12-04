<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToPedidoItemsTable extends Migration
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
            Schema::table('pedido_items', function (Blueprint $table)
            {
                $table->foreign('pedido_id', 'pedido_items_pedido_id_to_pedido_foreign')->references('id')->on('pedidos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
                $table->foreign('produto_id', 'pedido_items_produto_id_to_produto_foreign')->references('id')->on('produtos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
            Schema::table('pedido_items', function (Blueprint $table)
            {
                $table->dropForeign('pedido_items_pedido_id_to_pedido_foreign');
                $table->dropForeign('pedido_items_produto_id_to_produto_foreign');
            });
        }
    }
}
