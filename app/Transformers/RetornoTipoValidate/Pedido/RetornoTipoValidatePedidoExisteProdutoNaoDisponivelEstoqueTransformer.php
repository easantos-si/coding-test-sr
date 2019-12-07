<?php


namespace App\Transformers\RetornoTipoValidate\Pedido;


use App\Interfaces\Transformers\ValidacaoParametrosErrosInterface;
use App\Transformers\RetornoTiposErrors\RetornoTipoErroUnprocessableEntityTransformer;

class RetornoTipoValidatePedidoExisteProdutoNaoDisponivelEstoqueTransformer extends RetornoTipoErroUnprocessableEntityTransformer implements ValidacaoParametrosErrosInterface
{
    public function getCodigoErro(): int
    {
        return 1002;
    }

    public function getDescricaoErro(): string
    {
        return 'Existe um ou mais produtos não disponível no estoque.';
    }

    public function getCategoriaErro(): string
    {
        return 'Pedido';
    }
}
