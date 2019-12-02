<?php


namespace App\Transformers;


use App\Interfaces\Transformers\RetornoInterface;
use App\Interfaces\ApiVersionInterface;
use App\Interfaces\Transformers\RetornoTiposInterface;

abstract class RetornoTransformer implements RetornoInterface, ApiVersionInterface
{
    protected $data;
    protected $apiVersion;


    public function retorno(RetornoTiposInterface $retornoTipo):array
    {
        return [
            'data' => $this->data,
            'status' => $retornoTipo->getStatus(),
            'message' => $retornoTipo->getMessage(),
            'api-version' => $this->apiVersion,
        ];
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
