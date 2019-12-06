<?php


namespace App\Interfaces;


interface DataAuthInterface
{
    public function lojaId():int;
    public function lojaNome():string;
    public function lojaAtivo():bool;
    public function passaport():string;
    public function database():string;
    public function table():string;

}

