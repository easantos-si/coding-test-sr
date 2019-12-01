<?php


namespace App\Factories;


use App\Interfaces\Transformers\FuncionarioInterface;
use App\Models\Funcionario;

class FuncionarioTransformerFactory
{
    public static function getInstance(Funcionario $funcionario, int $apiVersion):FuncionarioInterface
    {
        return app()->make("App\Transformers\V{$apiVersion}\FuncionarioTransformer", [$funcionario]);
    }
}
