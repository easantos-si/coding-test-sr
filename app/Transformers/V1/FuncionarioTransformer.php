<?php


namespace App\Transformers\V1;

use App\Interfaces\Transformers\FuncionarioInterface;
use App\Models\Funcionario;
use App\Transformers\RetornoTransformer;

class FuncionarioTransformer extends RetornoTransformer implements FuncionarioInterface
{

    public function __construct()
    {
        $this->apiVersion = 1;
    }

    public function transform(Funcionario ...$funcionarios):void
    {
        $retorno = array();

        foreach ($funcionarios as $funcionario)
        {
            $retorno[] = [

            ];
        }
        $this->setData($retorno);
    }
}
