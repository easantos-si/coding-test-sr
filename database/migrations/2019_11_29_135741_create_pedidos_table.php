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

        if(!isDatabaseDefault())
        {
            Schema::create('pedidos', function (Blueprint $table) {
                $table->engine = 'innoDB';
                $table->bigIncrements('id');
                $table->string('codigo',100)->unique();
                $table->dateTime('data_compra');
                $table->string('nome_comprador',300);
                $table->enum('status',config('enums')['status']);
                $table->decimal('valor_frete');

                $table->timestamps();

                $table->index([DB::raw('codigo(50)')], 'pedidos_codigo_index');
                $table->index([DB::raw('codigo(50)'),'status'], 'pedidos_codigo_status_index');
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
            Schema::dropIfExists('pedidos');
        }
    }
}
