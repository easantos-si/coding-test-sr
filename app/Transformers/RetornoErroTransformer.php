<?php


namespace App\Transformers;


use App\Interfaces\Transformers\RetornoErroInterface;
use App\Interfaces\ApiVersionInterface;
use App\Interfaces\Transformers\RetornoTiposErroInterface;
use App\Interfaces\Transformers\RetornoTiposInterface;

abstract class  RetornoErroTransformer implements RetornoErroInterface, ApiVersionInterface
{
    protected $apiVersion;

    public function retorno(RetornoTiposErroInterface $retornoTipoErro):array
    {
        return [
            'data' => array(),
            'status' => $retornoTipoErro->getStatus(),
            'message' => $retornoTipoErro->getMessage(),
            'error' => $retornoTipoErro->getErro(),
            'api-version' => $this->apiVersion,
        ];
    }

    public function getVersion():int
    {
        return $this->apiVersion;
    }
}
