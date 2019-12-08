<?php


namespace App\Transformers;


use App\Interfaces\Transformers\RetornoTiposInterface;
use App\Interfaces\Transformers\ValidacaoParametrosErrosInterface;


abstract class  RetornoErroTransformer extends RetornoTransformer
{
    protected $data;
    protected $errors;
    protected $apiVersion;

    public function retorno(RetornoTiposInterface $retornoTipoError)
    {
        $retorno = $this->data;

        if($this->errors)
        {
            $retorno[] = [
                'errors' => $this->errors
            ];
        }

        return response()->json( [
            'data' => $retorno,
            'status' => $retornoTipoError->getStatus(),
            'success' => false,
            'message' => $retornoTipoError->getMessage(),
            'api-version' => $this->apiVersion,
        ],$retornoTipoError->getStatus());
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
