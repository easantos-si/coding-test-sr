<?php


namespace App\Interfaces\Transformers;


interface RetornoTiposInterface
{
    public function getStatus():int;
    public function getMessage():string;
}
