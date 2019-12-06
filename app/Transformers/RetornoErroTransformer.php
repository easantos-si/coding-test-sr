<?php


namespace App\Transformers;


use App\Interfaces\Transformers\RetornoTiposInterface;

abstract class  RetornoErroTransformer extends RetornoTransformer
{
    protected $data;
    protected $apiVersion;

    public function retorno(RetornoTiposInterface $retornoTipoErro):array
    {
        return [
            'data' => $this->data,
            'status' => $retornoTipoErro->getStatus(),
            'success' => false,
            'message' => $retornoTipoErro->getMessage(),
            'api-version' => $this->apiVersion,
        ];
    }

    public function getVersion():int
    {
        return $this->apiVersion;
    }
}
