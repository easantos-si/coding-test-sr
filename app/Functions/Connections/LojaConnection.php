<?php

namespace App\Functions\Connections;

trait LojaConnection{


    private function newConnections(string $dataBase):void
    {
        $connectionsNew = config("database.connections.mysql");
        $connectionsNew['database'] = $dataBase;
        config(["database.connections.{$dataBase}" => $connectionsNew]);
    }
}
