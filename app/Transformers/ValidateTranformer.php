<?php


namespace App\Transformers;


class ValidateTranformer extends RetornoErroTransformer
{
    public function __construct()
    {
        $this->data = array();
    }

    public function transform(array $retorno):void
    {
        $this->setData($retorno);
    }
}
