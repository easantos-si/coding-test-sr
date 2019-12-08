<?php


namespace App\Transformers;


use App\Interfaces\Transformers\RetornoTiposInterface;

abstract class RetornoAuthTransformer extends RetornoTransformer
{
    protected $data;
    protected $apiVersion;

    public function retorno(RetornoTiposInterface $retornoTipoAuth)
    {
        //dd(($retornoTipoAuth->getStatus()));
        return response()->json([
            'data' => $this->data,
            'status' => $retornoTipoAuth->getStatus(),
            'success' => ($retornoTipoAuth->getStatus() == 200),
            'message' => $retornoTipoAuth->getMessage(),
        ],200);//$retornoTipoAuth->getStatus());
    }
}
