<?php


namespace App\Interfaces\Transformers;


use App\Models\Funcionario;

interface FuncionarioInterface
{
    public function transform(Funcionario $funcionario);
}
