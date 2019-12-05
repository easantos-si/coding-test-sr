<?php

namespace App\Functions\Security;

use App\Models\Loja;

trait HashGenerator
{
    public function getHashLoja(Loja $loja):string
    {
        return bcrypt(md5("{$loja->id}-{$loja->passport}"));
    }

    public function getHashMascaraPasswordLogin(string $password):string
    {
        return md5($password);
    }

    public function getHashMascaraPasswordBancoDados(string $password):string
    {
        return bcrypt( $this->getHashMascaraPasswordLogin($password));
    }
}
