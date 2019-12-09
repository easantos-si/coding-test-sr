<?php


namespace App\Interfaces\Protections;


use phpDocumentor\Reflection\Types\Boolean;

interface CamposProtection
{
    public function getCamposRequeridos():array;
    public function getCamposValidacaoDados():array;
    public function getCamposInformacoes():array;
}
