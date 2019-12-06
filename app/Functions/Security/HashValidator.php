<?php

namespace App\Functions\Security;

trait HashValidator
{
    public function isValidHashLoja(string $passaport):\App\Models\Loja
    {
        $loja = app()->make('Lojas')->where('passaport', $passaport)->first();

        if(!$loja)
        {
            return null;
        }

        if(!password_verify(md5("{$loja->id}-{$passaport}"), $loja->hash_loja))
        {
            return null;
        }
        return $loja;
    }
}
