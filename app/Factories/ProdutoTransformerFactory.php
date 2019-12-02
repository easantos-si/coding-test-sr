<?php


namespace App\Factories;


use App\Interfaces\Transformers\ProdutoInterface;

class ProdutoTransformerFactory
{
    public static function getInstance(int $apiVersion):ProdutoInterface
    {
        return app()->make("App\Transformers\V{$apiVersion}\ProdutoTransformer");
    }
}
