<?php


namespace App\Protections\V1;


use App\Interfaces\ApiVersionInterface;
use App\Interfaces\Protections\CamposProtection;
use App\Interfaces\Protections\ValidarCamposProtection;
use App\Protections\DadosEntradaProtection;

class PedidoProtection extends DadosEntradaProtection implements CamposProtection, ValidarCamposProtection, ApiVersionInterface
{
    public function getCamposRequeridos(): array
    {
        return [
            'codigo'=> ['POST'],
            'data_compra' => ['POST'],
            'nome_comprador' => ['POST'],
            'status' => ['POST'],
            'valor_frete' => ['POST'],
        ];
    }

    public function getCamposValidacaoDados(): array
    {
        return [
            'codigo' => '`^[0-9A-ù]*$`',
            'data_compra' => '`^[0-9]{4}.[0-9]{2}.[0-9]{2}$|^[0-9]{4}.[0-9]{2}.[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$`',
            'nome_comprador' => '`^[A-ù0-9 ]*$`',
            'status' => '`^'.config('enums')['status'][0].'$|^'.config('enums')['status'][1].'$|^'.config('enums')['status'][2].'$|^'.config('enums')['status'][3].'$`',
            'valor_frete' => '`^[0-9]*[.]*[0-9]*$`',
        ];
    }

    public function getCamposInformacoes(): array
    {
        return [
            'codigo' => 'Este campo pode conter apenas números e letras',
            'data_compra' => 'Este campo pode conter apenas datas nos formatos YYYY?MM?DD ou YYYY?MM?DD HH:MM:SS (? representa um caractere separador)',
            'nome_comprador' => 'Este campo pode conter apenas números, letras e espaços',
            'status' => 'Este campo pode conter apenas os status disponíveis: ' . implode(', ', config('enums')['status']),
            'valor_frete' => 'Este campo pode conter apenas números e ponto Ex: 10.50 (Dez reais e cinquenta centavos)',
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
