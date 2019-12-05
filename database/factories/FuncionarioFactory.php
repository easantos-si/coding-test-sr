<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Funcionario;
use Faker\Generator as Faker;

$factory->define(Funcionario::class, function (Faker $faker) {
    return [
        'nome' => $nome = $faker->name,
        'email' => $faker->email,
        'senha' => bcrypt(md5($nome . '123')),
        'email_data_validacao' => \Carbon\Carbon::now(),
        'ativo' => 1,
    ];
});
