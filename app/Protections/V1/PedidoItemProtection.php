<?php


namespace App\Protections\V1;


use App\Interfaces\ApiVersionInterface;
use App\Interfaces\Protections\CamposProtection;
use App\Interfaces\Protections\ValidarCamposProtection;
use App\Protections\DadosEntradaProtection;
use App\Transformers\ValidateTranformer;

class PedidoItemProtection extends DadosEntradaProtection implements CamposProtection, ValidarCamposProtection, ApiVersionInterface
{
    public function getCamposRequeridos(): array
    {
        return [
            //'pedido'=> ['POST'],
            'produto'=> ['POST'],
            'quantidade' => ['POST'],
            'preco' => ['POST'],
        ];
    }

    public function getCamposValidacaoDados(): array
    {
        return [
            'pedido' => '`^[0-9A-ù]*$`',
            'produto' => '`^[0-9A-ù]*$`',
            'quantidade_estoque' => '`^[0-9]*$`',
            'preco' => '`^[0-9]*[.]*[0-9]*$`',
        ];
    }

    public function getCamposInformacoes(): array
    {
        return [
            'pedido' => 'Este campo pode conter apenas números e letras',
            'produto' => 'Este campo pode conter apenas números e letras',
            'quantidade' => 'Este campo pode conter apenas números',
            'preco' => 'Este campo pode conter apenas números e ponto Ex: 10.50  (Dez reais e cinquenta centavos)',
        ];
    }

    public function validar(array $parametros): bool
    {
        return $this->processarValidacao($this,$this->getVersion(), $parametros);
    }

    public function getVersion(): int
    {
        return 1;
    }
}
