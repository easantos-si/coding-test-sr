<?php


namespace App\Transformers;


use App\Interfaces\Transformers\RetornoInterface;
use App\Interfaces\ApiVersionInterface;
use Carbon\Carbon;

abstract class RetornoTransformer implements RetornoInterface, ApiVersionInterface
{
    protected $data;
    protected $status;
    protected $error;
    protected $apiVersion;

//Criar estrutura separada para estatisticas
//    protected $dateTimeRequest;
//    protected $dateTimeRespose;

    public function retorno():array
    {

//Criar estrutura separada para estatisticas
//        $this->dateTimeRespose = Carbon::now();

        return [
            'data' => $this->data,
            'status' => $this->status,
            'error' => $this->error,
            'api-version' => $this->apiVersion,
//Criar estrutura separada para estatisticas
//            'statistic' => [
//                'request' => [
//                    'date' => $this->dateTimeRequest->format('Y-m-d'),
//                    'time' => $this->dateTimeRequest->format('H:i:s.u')],
//                'respose' => [
//                    'date' => $this->dateTimeRespose->format('Y-m-d'),
//                    'time' => $this->dateTimeRespose->format('H:i:s.u')
//                ],
//                'duration' => [
//                    'inSeconds' => $this->dateTimeRespose->diffInSeconds( $this->dateTimeRequest),
//                    'inMilliseconds' => $this->dateTimeRespose->diffInMilliseconds( $this->dateTimeRequest),
//                    'inMicroseconds' => $this->dateTimeRespose->diffInMicroseconds( $this->dateTimeRequest),
//                ],
//            ],
        ];
    }

    public function getVersion():int
    {
        return $this->apiVersion;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function setError(int $error, string $message): void
    {
        $this->error = [
            'id' => $error,
            'message' => $message
        ];
    }
}
