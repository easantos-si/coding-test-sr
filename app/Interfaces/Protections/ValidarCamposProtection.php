<?php


namespace App\Interfaces\Protections;


use http\Env\Request;

interface ValidarCamposProtection
{
    public function validar(array $parametros):bool;
}
