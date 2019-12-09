<?php


namespace App\Protections\V1;


use App\Interfaces\ApiVersionInterface;
use App\Interfaces\Protections\CamposProtection;
use App\Interfaces\Protections\ValidarCamposProtection;
use App\Protections\DadosEntradaProtection;

class ProdutoProtection extends DadosEntradaProtection implements CamposProtection, ValidarCamposProtection, ApiVersionInterface
{

    public function getCamposRequeridos(): array
    {
        return [
            'codigo'=> ['POST'],
            'nome' => ['POST'],
            //'descricao' => ['POST'],
            'quantidade_estoque' => ['POST'],
            'preco' => ['POST'],
        ];
    }

    public function getCamposValidacaoDados(): array
    {
        return [
            'codigo' => '`^[0-9A-ù]*$`',
            'nome' => '`^[A-ù ]*$`',
            'descricao' => '`^[A-ù0-9 ]*$`',
            'quantidade_estoque' => '`^[0-9]*$`',
            'preco' => '`^[0-9]*[.]*[0-9]*$`',
        ];
    }

    public function getCamposInformacoes(): array
    {
        return [
            'codigo' => 'Este campo pode conter apenas números e letras',
            'nome' => 'Este campo pode conter apenas letras',
            'descricao' => 'Este campo pode conter apenas números, letras e espaços',
            'quantidade_estoque' => 'Este campo pode conter apenas números',
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
