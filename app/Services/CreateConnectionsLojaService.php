<?php


namespace App\Services;


class CreateConnectionsLojaService
{
    protected $dataBase;

    public function __construct(string $dataBase)
    {
        $this->dataBase = $dataBase;
    }

    public function newConnection(): void
    {
        $connectionsNew = config("database.connections.mysql");
        $connectionsNew['database'] = $this->dataBase;
        config(["database.connections.{$this->dataBase}" => $connectionsNew]);
    }
}
