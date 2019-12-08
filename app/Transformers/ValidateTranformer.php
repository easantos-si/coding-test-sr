<?php


namespace App\Transformers;


use App\Interfaces\ApiVersionInterface;

class ValidateTranformer extends RetornoErroTransformer
{
    protected $data;
    protected $errors;
    protected $apiVersion;

    public function __construct()
    {
        $this->data = array();
    }

    public function transform(array $retorno):void
    {
        $this->setData($retorno);
    }

    public function setApiVersion(int $apiVersion)
    {
        $this->apiVersion = $apiVersion;
    }
}
