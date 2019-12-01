<?php

namespace App\Http\Controllers;

use App\Repositories\LojaRepository;

class LojaController extends Controller
{

    public function index(LojaRepository $lojaRepository)
    {
        return $lojaRepository->getTodasLojas();
    }
}
