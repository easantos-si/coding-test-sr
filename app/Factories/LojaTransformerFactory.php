<?php


namespace App\Factories;

use App\Interfaces\Transformers\LojaInterface;
use App\Models\Loja;
use App\Transformers\V1\LojaTransformer;

class LojaTransformerFactory
{
    public static function getInstance(int $apiVersion):LojaInterface
    {
        return app()->make("App\Transformers\V{$apiVersion}\LojaTransformer");
    }
}
