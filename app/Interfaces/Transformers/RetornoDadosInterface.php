<?php


namespace App\Interfaces\Transformers;


interface RetornoDadosInterface
{
    public function setData(array $data):void;
    public function setStatus(int $status):void;
    public function setError(int $error, string $message):void;
}
