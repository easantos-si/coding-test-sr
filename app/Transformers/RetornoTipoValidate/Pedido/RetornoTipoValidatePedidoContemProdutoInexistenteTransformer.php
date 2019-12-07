<?php


namespace App\Transformers\RetornoTipoValidate\Pedido;


use App\Transformers\RetornoTiposErrors\RetornoTipoErroUnprocessableEntityTransformer;
use App\Interfaces\Transformers\ValidacaoParametrosErrosInterface;

class RetornoTipoValidatePedidoContemProdutoInexistenteTransformer extends RetornoTipoErroUnprocessableEntityTransformer implements ValidacaoParametrosErrosInterface
{

    public function getCodigoErro(): int
    {
        return 1001;
    }

    public function getDescricaoErro(): string
    {
        return 'Existe um ou mais produtos não cadastrados no sistema.';
    }

    public function getCategoriaErro(): string
    {
        return 'Pedido';
    }
}
