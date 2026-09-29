<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->json(User::orderBy('name')->get());
    }

  
    public function show(User $usuario): JsonResponse
    {
        return response()->json($usuario);
    }


    public function store(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        return response()->json(User::create($dados), 201);
    }

   
    public function update(Request $request, User $usuario): JsonResponse
    {
        $dados = $request->validate([
            'name'     => ['sometimes', 'string', 'max:255'],
            'email'    => ['sometimes', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuario->id)],
            'password' => ['sometimes', 'string', 'min:8'],
        ]);

        $usuario->update($dados);

        return response()->json($usuario->fresh());
    }

    public function destroy(User $usuario): JsonResponse
    {
        $usuario->tokens()->delete();
        $usuario->delete();

        return response()->json(['message' => 'Usuário removido com sucesso.']);
    }
}
