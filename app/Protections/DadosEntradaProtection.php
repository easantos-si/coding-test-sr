<?php


namespace App\Protections;


use App\Interfaces\ApiVersionInterface;
use App\Interfaces\Protections\CamposProtection;
use App\Interfaces\Protections\ErrosProtection;
use App\Transformers\RetornoTiposErrors\RetornoTipoErroUnprocessableEntityTransformer;
use App\Transformers\ValidateTranformer;

abstract class DadosEntradaProtection implements ErrosProtection
{
    private $erros;
    private $validateTranformer;
    private $metodo;

    public function __construct(string $metodo, ValidateTranformer $validateTranformer)
    {
        $this->metodo = $metodo;
        $this->erros = array();
        $this->validateTranformer = $validateTranformer;
    }

    public function processarValidacao(CamposProtection $camposProtection, int $apiVersion, array $parametros): bool
    {
        $this->validateTranformer->setApiVersion($apiVersion);
        foreach($camposProtection->getCamposRequeridos() as $nomeCampo => $verbosHtml)
        {
            if(in_array($this->metodo, $verbosHtml) && !array_key_exists($nomeCampo, $parametros))
            {
                $this->informarCampoRequerido($nomeCampo, $camposProtection->getCamposInformacoes()[$nomeCampo]);
            }
        }

        foreach($camposProtection->getCamposValidacaoDados() as $nomeCampo => $regex)
        {
            if(isset($parametros[$nomeCampo]) && !preg_match($regex, $parametros[$nomeCampo]))
            {
                $this->informarCampoDadoInvalido($nomeCampo,$parametros[$nomeCampo], $camposProtection->getCamposInformacoes()[$nomeCampo]);
            }
        }

        return $this->dadosValidos();
    }

    public function informarCampoRequerido(string $nomeCampo, string $informacao):void
    {
        $this->erros[] = [
            'Erro' => "O campo  '{$nomeCampo}' é obrigatório",
            'Informação' => $informacao,
        ];
    }

    public function informarCampoDadoInvalido(string $nomeCampo,string $valorCampo, string $informacao):void
    {
        $this->erros[] = [
            'Erro' => "O valor '{$valorCampo}' não é aceito para o campo '{$nomeCampo}'",
            'Informação' => $informacao,
        ];
    }

    public function getErros():array
    {
        return $this->erros;
    }

    public function dadosValidos():bool
    {
        return count($this->erros) == 0;
    }

    public function transformer()
    {
        $this->validateTranformer->transform($this->getErros());
    }

    public function retorno()
    {
        return $this->validateTranformer->retorno(new RetornoTipoErroUnprocessableEntityTransformer());
    }

    abstract public function getVersion(): int;
}
