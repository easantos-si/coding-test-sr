<?php


namespace App\Factories;


use App\Interfaces\Transformers\LojaInterface;

class LojaTransformerFactory
{
    public static function getInstance(int $apiVersion):LojaInterface
    {
        return app()->make("App\Transformers\V{$apiVersion}\LojaTransformer");
    }
}
