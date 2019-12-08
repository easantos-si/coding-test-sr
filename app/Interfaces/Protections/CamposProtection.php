<?php


namespace App\Interfaces\Protections;


interface CamposProtection
{
    public function getCamposRequeridos():array;
    public function getCamposValidacaoDados():array;
    public function getCamposInformacoes():array;
}
