<?php


namespace App\Transformers\V1;

use App\Interfaces\Transformers\FuncionarioInterface;
use App\Models\Funcionario;
use App\Transformers\RetornoTransformer;

class FuncionarioTransformer extends RetornoTransformer implements FuncionarioInterface
{

    public function transform(Funcionario $funcionario): array
    {
        $this->data = [

        ];
    }
}
