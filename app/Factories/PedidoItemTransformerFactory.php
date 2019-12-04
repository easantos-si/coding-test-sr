<?php


namespace App\Factories;


use App\Interfaces\Transformers\PedidoItemInterface;

class PedidoItemTransformerFactory
{
    public static function getInstance(int $apiVersion):PedidoItemInterface
    {
        return app()->make("App\Transformers\V{$apiVersion}\PedidoItemTransformer");
    }
}
