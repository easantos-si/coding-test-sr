<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('App.Funcionario.{id}', function ($funcionario, $id) {
    return (int) $funcionario->id === (int) $id;
});

Broadcast::channel('App.Loja.{id}', function ($loja, $id) {
    return (int) $loja->id === (int) $id;
});
