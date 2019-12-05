<?php
//function getLojasMigrateNomeBases()
//{
//    $lojasAtualizacao = null;
//    try
//    {
//        $lojasAtualizacao = \App\Models\Loja::whereAtivo(1)->get();
//    }
//    catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex)
//    {
//
//    }
//    return $lojasAtualizacao;
//}
//
//function getLojasMigrateUp()
//{
//    $lojasAtualizacao = null;
//    try
//    {
//        $lojasAtualizacao = \App\Models\LojaMigration::with('\App\Models\Loja')->whereProcessado(0)->whereMigration(1)->get();
//    }
//    catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex)
//    {
//
//    }
//
//    return $lojasAtualizacao;
//}
//
//function getLojasMigrateDown()
//{
//    $lojasAtualizacao = null;
//    try
//    {
//        $lojasAtualizacao = \App\Models\LojaMigration::with('\App\Models\Loja')->whereProcessado(0)->whereRollback(1)->get();
//    }
//    catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex)
//    {
//
//    }
//    return $lojasAtualizacao;
//}

function getConnectionNameDefault():string
{
    return 'mysql';
}

function isDatabaseDefault():bool
{
    return (config('database')['connections'][getConnectionNameDefault()]['database'] == \Illuminate\Support\Facades\DB::connection()->getConfig()['database']);
}
