<?php


namespace App\Interfaces\Transformers;


use App\Models\Loja;

interface LojaInterface
{
    public function transform(Loja ...$loja):void;
}
