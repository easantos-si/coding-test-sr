<?php


namespace App\Transformers;


use App\Interfaces\Transformers\RetornoInterface;
use App\Interfaces\ApiVersionInterface;
use App\Interfaces\Transformers\RetornoTiposInterface;
use http\Env\Response;

abstract class RetornoTransformer implements RetornoInterface, ApiVersionInterface
{
    protected $data;
    protected $apiVersion;

    public function retorno(RetornoTiposInterface $retornoTipo)
    {
        return response()->json( [
            'data' => $this->data,
            'status' => $retornoTipo->getStatus(),
            'success' => true,
            'message' => $retornoTipo->getMessage(),
            'api-version' => $this->apiVersion,
        ],$retornoTipo->getStatus());
    }

    public function getVersion():int
    {
        return $this->apiVersion;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
