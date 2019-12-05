<?php

namespace App\Functions\Security;

trait HashValidator
{
    public function isValidHashLoja(string $passport):\App\Models\Loja
    {
        $loja = app()->make('Lojas')->where('passport', $passport)->first();

        if(!$loja)
        {
            return null;
        }

        if(!password_verify(md5("{$loja->id}-{$passport}"), $loja->hash_loja))
        {
            return null;
        }
        return $loja;
    }
}
