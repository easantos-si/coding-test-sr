<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
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
            Schema::connection($lojaMigate->loja->base_dados_nome)->create('pedidos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nome_comprador'); //??? Pq nome do comprador... deveria ser cliente_id e no crud buscar o nome via relacionamento pedido_cliente, mas só esta pedindo crud de produto e pedido
                $table->decimal('valor_frete');
                $table->integer('status');
                $table->dateTime('data_compra');
                $table->timestamps();
            });
            //Seria interessante o pedido conter o valor total, para evitar calculos desnecessários em relatórios
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
            Schema::connection($lojaMigate->loja->base_dados_nome)->dropIfExists('pedidos');
            $lojaMigate->processado = 1;
        }
    }
}
