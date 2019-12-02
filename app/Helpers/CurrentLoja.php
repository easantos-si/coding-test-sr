<?php
function currentLojaId():int
{
    $lojaId = 0;

    if(isset($_SERVER['REQUEST_URI'])){
        preg_match('`api\/v[0-9]+\/([0-9]+)\/`', $_SERVER['REQUEST_URI'], $matches);
        if($matches)
        {
            $lojaId = (int)$matches[1];
        }
    }
    return $lojaId;
}

function currentLoja()
{
    return getLoja(currentLojaId());
}

function currentLojaBaseDados()
{
    return getLojaBaseDados(currentLojaId());
}

function getLoja(int $lojaId)
{
    return app()->make('Lojas')->find($lojaId);
}

function getLojaBaseDados(int $lojaId)
{
    return getLoja($lojaId)->base_dados_nome;
}
