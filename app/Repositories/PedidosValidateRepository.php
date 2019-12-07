<?php


namespace App\Repositories;


use App\Interfaces\Transformers\RetornoTiposInterface;
use App\Models\Pedido;
use App\Transformers\RetornoTipoValidate\Pedido\RetornoTipoValidatePedidoContemProdutoInexistenteTransformer;
use App\Transformers\RetornoTipoValidate\Pedido\RetornoTipoValidatePedidoExisteProdutoNaoDisponivelEstoqueTransformer;
use App\Transformers\ValidateTranformer;

class PedidosValidateRepository
{
    private $validateTranformer;
    private $pedidoRepository;
    private $produtoRepository;

    public function __construct(ValidateTranformer $validateTranformer , PedidoRepository $pedidoRepository, ProdutoRepository $produtoRepository)
    {
        $this->validateTranformer = $validateTranformer;
        $this->pedidoRepository = $pedidoRepository;
        $this->produtoRepository = $produtoRepository;
    }

    public function validarPedido(array $parametros):bool
    {
        //Não usei return porque a estrutura comporta varias validações
        $sucesso = true;

        if(!$this->isTodosProdutosExiste($parametros))
        {
            $sucesso = false;
            $this->validateTranformer->adicionarErros(new RetornoTipoValidatePedidoContemProdutoInexistenteTransformer());
        }
//        else
//            if(!$this->isTodosProdutosTemDisponibilidadeEstoque($parametros))
//            {
//                $sucesso = false;
//                $this->validateTranformer->adicionarErros(new RetornoTipoValidatePedidoExisteProdutoNaoDisponivelEstoqueTransformer());
//            }

        return $sucesso;
    }

    public function isTodosProdutosExiste(array $parametros):bool
    {
        return $this->produtoRepository->todosProdutosExiste(

            $this->produtoRepository->extrairCodigoProdutosListaItensPedidoCadastro(
                $this->pedidoRepository->extrairListaItensPedidoCadastro($parametros)

            )
        );
    }
    public function isTodosProdutosTemDisponibilidadeEstoque(array $parametros):bool
    {
        return $this->produtoRepository->todosProdutosExisteDisponibilidadeEstoque(

            $this->produtoRepository->extrairCodigoProdutosQuantidadeListaItensPedidoCadastro(
                $this->pedidoRepository->extrairListaItensPedidoCadastro($parametros)

            )
        );
    }

    public function transformer(array $info):void
    {
        $this->validateTranformer->transform($info);
    }

    public function retorno(RetornoTiposInterface $retornoTipoErro)
    {
        return $this->validateTranformer->retorno($retornoTipoErro);
    }

}
