<?php


namespace App\Repositories;

use App\Factories\PedidoTransformerFactory;
use App\Interfaces\Transformers\RetornoTiposInterface;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class PedidoRepository
{
    private $pedido;
    private $pedidoTransformer;
    private $pedidoItemRepository;

    public function __construct(PedidoItemRepository $pedidoItemRepository, Pedido $pedido)
    {
        $this->pedidoItemRepository  = $pedidoItemRepository;
        $this->pedido = $pedido;
        $this->pedidoTransformer = PedidoTransformerFactory::getInstance( currentVersionApi());
    }

    private function extrairListaPedidoArray(array $parametros):array
    {
        return $parametros['lista_itens_pedido'] ?? array();
    }

    public function pedidos():iterable
    {
        return $this->pedido->all()
            ->flatten(1)
            ->values()
            ->all();
    }

    public function pedido(string $codigo):Pedido
    {
        return $this->pedido->whereCodigo($codigo)
            ->first();
    }

    public function criar(array $parametros):Pedido
    {
        $pedido = null;
        DB::beginTransaction();
        try
        {
            $pedido = $this->pedido->create($parametros);

            $this->pedidoItemRepository->criarPeloPedido(
                $pedido,
                $this->extrairListaPedidoArray($parametros)
            );
            DB::commit();
        }
        catch (ModelNotFoundException $ex)
        {
            DB::rollBack();
        }
        return $pedido;
    }

    public function atualizar(Pedido $pedido, array $parametros):Pedido
    {
        $codigoAnterior = $pedido->codigo;

        $pedido->update($parametros);

        if($pedido->codigo != $codigoAnterior)
        {
            $pedido->atualizarCodigoPedidoItems($codigoAnterior,$pedido->codigo);
        }

        return $pedido;
    }
    public function deletar(Pedido $pedido):Pedido
    {
        $pedido->deletarTodosPedidoItems();

        $pedido->delete();

        return $pedido;
    }


    public function extrairPedidoArray(array $parametros):Pedido
    {
        return $this->pedido($parametros['pedido']);
    }

    public function transformer(Pedido $pedido):void
    {
        $this->pedidoTransformer->transform($pedido);
    }

    public function transformers(Pedido... $pedidos):void
    {
        $this->pedidoTransformer->transform(...$pedidos);
    }

    public function retorno(RetornoTiposInterface $retornoTipo)
    {
        return $this->pedidoTransformer->retorno($retornoTipo);
    }
}
