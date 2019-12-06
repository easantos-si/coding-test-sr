<?php

namespace App\Console\Commands;

use App\Models\Loja;
use App\Models\Funcionario;
use App\Functions\Security\HashGenerator;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CriarLoja extends Command
{
  use HashGenerator;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'criar:loja {nome?} {senha?} {nome-base?} {ativo?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para criação de loja - Parametros: nome, senha, nome-base, ativo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::transaction(function ()
        {
            $erro = false;
            try
            {

                $loja = Loja::create(
                    [
                        'name' => $this->argument('nome'),
                        'password' => $this->getHashMascaraPasswordBancoDados($this->argument('senha')),
                        'base_dados_nome' => $this->argument('nome-base'),
                        'ativo' => $this->argument('ativo'),
                        'remember_token' => Str::random(10),
                        'passaport' => Str::random(10),
                    ]
                );

                $loja->hash_loja = $this->getHashLoja($loja);
                $loja->save();

                $erro = $this->criarBaseDados();

                if(!$erro)
                {
                    Artisan::call('migrate',['--database' => $this->argument('nome-base')]);

                    Funcionario::on($this->argument('nome-base'))->create(
                        [
                            'name'=> 'teste',
                            'email' => 'teste@teste.com.br',
                            'email_verified_at' => Carbon::now(),
                            'password' => $this->getHashMascaraPasswordBancoDados('teste@123'),
                            'ativo' => 0,
                            'remember_token' => Str::random(10),
                        ]
                    );
                }

                if(!$erro)
                {
                    DB::commit();
                }
                else
                {
                    DB::rollBack();
                }

            }
            catch (ModelNotFoundException $ex)
            {
                $erro = true;
                DB::rollBack();
            }
        });
    }

    private function criarBaseDados():bool
    {
        $erro = false;

        try
        {

            $schemaName = $this->argument('nome-base');
            $charset = config("database.connections.mysql.charset",'utf8mb4');
            $collation = config("database.connections.mysql.collation",'utf8mb4_unicode_ci');

            config(["database.connections.mysql.database" => null]);

            $query = "CREATE DATABASE IF NOT EXISTS $schemaName CHARACTER SET $charset COLLATE $collation;";

            DB::statement($query);

            $baseDados = config("database.connections.mysql");
            $baseDados['database'] = $schemaName;
            config(["database.connections.{$schemaName}" => $baseDados]);

        }
        catch (\mysqli_sql_exception $ex)
        {
            $erro = true;
        }

        return $erro;
    }
}
