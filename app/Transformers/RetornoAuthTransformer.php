<?php


namespace App\Transformers;


use App\Interfaces\Transformers\RetornoTiposInterface;

class RetornoAuthTransformer extends RetornoTransformer
{
    protected $data;
    protected $apiVersion;

    public function retorno(RetornoTiposInterface $retornoTipoAuth):array
    {
        return [
            'data' => $this->data,
            'status' => $retornoTipoAuth->getStatus(),
            'success' => ($retornoTipoAuth->getStatus() == 200),
            'message' => $retornoTipoAuth->getMessage(),
        ];
    }

    public function getVersion():int
    {
        return $this->apiVersion;
    }
}
