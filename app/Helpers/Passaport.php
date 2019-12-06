<?php
function currentPassaport():array
{
    $passaport = [
        'key'=> '',
        'admin'=> false,
    ];

    if(isset($_SERVER['REQUEST_URI'])){
        preg_match('`login/([^/]*)/?(.*)/?$`', $_SERVER['REQUEST_URI'], $matches);
        if($matches)
        {
            $passaport['key'] = $matches[1];
            $passaport['admin'] = (strtolower( $matches[2]) == 'admin');
        }
    }
    return $passaport;
}
