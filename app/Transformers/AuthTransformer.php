<?php


namespace App\Transformers;


class AuthTransformer extends RetornoAuthTransformer
{
    protected $data;
    protected $apiVersion;

    public function __construct()
    {
        $this->data = array();
    }

    public function transform(array $retorno):void
    {
        $this->setData($retorno);
    }
}
