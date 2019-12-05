<?php


namespace App\Repositories;

use App\Factories\PedidoTransformerFactory;
use App\Interfaces\Transformers\RetornoTiposInterface;
use App\Models\Pedido;
use App\Services\CriarItensPeloPedidoService;
use App\Services\DeletarItensPeloPedidoService;
use Illuminate\Support\Facades\DB;

class PedidoRepository
{
    private $dataAuthRepository;
    private $pedidoTransformer;

    public function __construct(DataAuthRepository $dataAuthRepository)
    {
        $this->dataAuthRepository = $dataAuthRepository;
        $this->dataAuthRepository->newConnection();
        $this->pedidoTransformer = PedidoTransformerFactory::getInstance( currentVersionApi());
    }

    public function pedidos():iterable
    {
        return Pedido::on($this->dataAuthRepository->database())->get()
            ->flatten(1)
            ->values()
            ->all();
    }

    public function pedido(string $codigo):Pedido
    {
        return Pedido::on($this->dataAuthRepository->database())->whereCodigo($codigo)
            ->first();
    }

    public function criar(array $parametros):Pedido
    {
        $pedido = null;
        DB::beginTransaction();
        try
        {
            $pedido = Pedido::on($this->dataAuthRepository->database())->create($parametros);

            $criarItensPedidosPeloPedido = new CriarItensPeloPedidoService(
                $pedido,
                new PedidoItemRepository(
                    $this->dataAuthRepository,
                    new ProdutoRepository(
                        $this->dataAuthRepository)
                ),
                $parametros);
            $criarItensPedidosPeloPedido->criar();

            DB::commit();
        }
        catch (ModelNotFoundException $ex)
        {
            DB::rollBack();
        }
        catch (FatalThrowableError $ex)
        {
            DB::rollBack();
        }
        return $pedido;
    }

    public function atualizar(Pedido $pedido, array $parametros):Pedido
    {
        try
        {
            $codigoAnterior = $pedido->codigo;

            $pedido->update($parametros);

            if($pedido->codigo != $codigoAnterior)
            {
                $pedido->atualizarCodigoPedidoItems($codigoAnterior,$pedido->codigo);
            }
            DB::commit();
        }
        catch (ModelNotFoundException $ex)
        {
            DB::rollBack();
        }

        return $pedido;
    }
    public function deletar(Pedido $pedido):Pedido
    {
        try
        {
            $deletarItensPeloPedido = new DeletarItensPeloPedidoService($pedido);
            $deletarItensPeloPedido->deletar();
            $pedido->delete();
            DB::commit();
        }
        catch (ModelNotFoundException $ex)
        {
            DB::rollBack();
        }
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
