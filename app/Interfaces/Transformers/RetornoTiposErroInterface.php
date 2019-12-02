<?php


namespace App\Interfaces\Transformers;


interface RetornoTiposErroInterface
{
    public function getStatus():int;
    public function getErro():int;
    public function getMessage():string;
}
