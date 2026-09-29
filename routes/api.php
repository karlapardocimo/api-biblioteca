<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AutorController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\LivroController;
use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas públicas
|--------------------------------------------------------------------------
| Consultas (GET) ficam abertas para qualquer aplicação cliente.
*/
Route::get('/', fn () => response()->json([
    'api'       => 'API Biblioteca - Desenvolvimento Web III',
    'endpoints' => ['/api/livros', '/api/autores', '/api/categorias'],
]));

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('autores', AutorController::class)
    ->parameters(['autores' => 'autor'])
    ->only(['index', 'show']);

Route::apiResource('categorias', CategoriaController::class)
    ->parameters(['categorias' => 'categoria'])
    ->only(['index', 'show']);

Route::apiResource('livros', LivroController::class)
    ->parameters(['livros' => 'livro'])
    ->only(['index', 'show']);

/*
|--------------------------------------------------------------------------
| Rotas protegidas (Laravel Sanctum)
|--------------------------------------------------------------------------
| Cadastro, alteração e exclusão exigem o header:
| Authorization: Bearer {token}
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('autores', AutorController::class)
        ->parameters(['autores' => 'autor'])
        ->except(['index', 'show']);

    Route::apiResource('categorias', CategoriaController::class)
        ->parameters(['categorias' => 'categoria'])
        ->except(['index', 'show']);

    Route::apiResource('livros', LivroController::class)
        ->parameters(['livros' => 'livro'])
        ->except(['index', 'show']);

    Route::apiResource('usuarios', UsuarioController::class)
        ->parameters(['usuarios' => 'usuario']);
});
