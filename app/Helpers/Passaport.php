<?php
function currentPassaport():string
{
    $passaport = '';

    if(isset($_SERVER['REQUEST_URI'])){
        preg_match('`login\/([^/]*?)(\/)?$`', $_SERVER['REQUEST_URI'], $matches);
        if($matches)
        {
            $passaport = $matches[1];
        }
    }
    return $passaport;
}
