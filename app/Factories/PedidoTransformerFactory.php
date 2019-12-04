<?php


namespace App\Factories;


use App\Interfaces\Transformers\PedidoInterface;

class PedidoTransformerFactory
{
    public static function getInstance(int $apiVersion):PedidoInterface
    {
        return app()->make("App\Transformers\V{$apiVersion}\PedidoTransformer");
    }
}
