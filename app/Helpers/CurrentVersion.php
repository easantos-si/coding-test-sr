<?php

function currentVersionApi():int
{
    $version = 0;

    if(isset($_SERVER['REQUEST_URI'])){
        preg_match('`api\/v([0-9]+)\/`', $_SERVER['REQUEST_URI'], $matches);
        if($matches)
        {
            $version = (int)$matches[1];
        }
    }
    return $version;
}
