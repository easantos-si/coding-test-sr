<?php


namespace App\Factories;


use App\Interfaces\Transformers\FuncionarioInterface;

class FuncionarioTransformerFactory
{
    public static function getInstance(int $apiVersion):FuncionarioInterface
    {
        return app()->make("App\Transformers\V{$apiVersion}\FuncionarioTransformer");
    }
}
