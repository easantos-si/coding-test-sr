<?php


namespace App\Transformers\V1;


use App\Interfaces\Transformers\LojaInterface;
use App\Models\Loja;
use App\Transformers\RetornoTransformer;
use Carbon\Carbon;

class LojaTransformer extends RetornoTransformer implements LojaInterface
{
    public function __construct()
    {
        $this->dateTimeRequest = Carbon::now();
        $this->apiVersion = 1;
    }

    public function transform(Loja ...$loja)
    {

        $this->setData(['ok']);
    }
}
