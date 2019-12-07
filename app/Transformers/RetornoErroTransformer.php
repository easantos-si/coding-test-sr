<?php


namespace App\Transformers;


use App\Interfaces\Transformers\RetornoTiposInterface;
use App\Interfaces\Transformers\ValidacaoParametrosErrosInterface;


abstract class  RetornoErroTransformer extends RetornoTransformer
{
    protected $data;
    protected $errors;
    protected $apiVersion;

    public function retorno(RetornoTiposInterface $retornoTipoError):array
    {
        $retorno = $this->data;

        $retorno[] = [
            'errors'=>$this->errors
        ];

        return [
            'data' => $retorno,
            'status' => $retornoTipoError->getStatus(),
            'message' => $retornoTipoError->getMessage(),
        ];
    }

    public function adicionarErros(ValidacaoParametrosErrosInterface $validacaoParametrosErros):void
    {
        $this->errors[] = [
            'code' => $validacaoParametrosErros->getCodigoErro(),
            'description' => $validacaoParametrosErros->getDescricaoErro(),
            'type' => $validacaoParametrosErros->getCategoriaErro(),
        ];
    }
}
