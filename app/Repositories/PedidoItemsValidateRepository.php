<?php


namespace App\Repositories;


use App\Interfaces\Transformers\RetornoTiposInterface;
use App\Transformers\RetornoTipoValidate\Pedido\RetornoTipoValidatePedidoContemProdutoInexistenteTransformer;
use App\Transformers\RetornoTipoValidate\Pedido\RetornoTipoValidatePedidoExisteProdutoNaoDisponivelEstoqueTransformer;
use App\Transformers\ValidateTranformer;

class PedidoItemsValidateRepository
{
    private $validateTranformer;
    private $pedidoRepository;
    private $produtoRepository;
    private $pedidoItemRepository;

    public function __construct(ValidateTranformer $validateTranformer ,
                                PedidoRepository $pedidoRepository,
                                ProdutoRepository $produtoRepository,
                                PedidoItemRepository $pedidoItemRepository
    )
    {
        $this->validateTranformer = $validateTranformer;
        $this->pedidoRepository = $pedidoRepository;
        $this->produtoRepository = $produtoRepository;
        $this->pedidoItemRepository = $pedidoItemRepository;
    }

    public function validarPedidoItem(array $parametros):bool
    {
        //Não usei return porque a estrutura comporta varias validações
        $sucesso = true;

        if(!$this->isProdutoExiste($parametros))
        {
            $sucesso = false;
            $this->validateTranformer->adicionarErros(new RetornoTipoValidatePedidoContemProdutoInexistenteTransformer());
        }
        else
            if(!$this->isProdutoTemDisponibilidadeEstoque($parametros))
            {
                $sucesso = false;
                $this->validateTranformer->adicionarErros(new RetornoTipoValidatePedidoExisteProdutoNaoDisponivelEstoqueTransformer());
            }

        return $sucesso;
    }

    public function isProdutoExiste(array $parametros):bool
    {
        return $this->produtoRepository->todosProdutosExiste([
                $this->produtoRepository->extrairCodigoProdutoListaItemPedidoCadastro(
                $parametros
                        )
            ]
        );
    }
    public function isProdutoTemDisponibilidadeEstoque(array $parametros):bool
    {
        return $this->produtoRepository->todosProdutosExisteDisponibilidadeEstoque(
            [
                $this->produtoRepository->extrairCodigoProdutoQuantidadeListaItemPedidoCadastro(
                    $parametros
                )
            ]
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
