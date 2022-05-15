<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Users;
use App\Http\Controllers\Api\AuthController;

#### - Autenticacao - ####

// Registrar novo usuario - desabilitado
Route::post('/register', [AuthController::class, 'register']);

// Login de usuario
Route::post('/login', [AuthController::class, 'login']);

// Recuperacao de senha
Route::post('/login/recuperar', [AuthController::class, 'forgotPassword']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // Obter o perfil do usuario
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::get('/users', Users\Index::class)->name('api.users.index');
});
