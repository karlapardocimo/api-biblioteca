<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // GET /api/categorias
    public function index(): JsonResponse
    {
        return response()->json(Categoria::orderBy('nome')->get());
    }

    // GET /api/categorias/{id}
    public function show(Categoria $categoria): JsonResponse
    {
        return response()->json($categoria->load('livros.autor'));
    }

    // POST /api/categorias
    public function store(Request $request): JsonResponse
    {
        $dados = $request->validate($this->regras());
        $categoria = Categoria::create($dados);

        return response()->json($categoria, 201);
    }

    // PUT /api/categorias/{id}
    public function update(Request $request, Categoria $categoria): JsonResponse
    {
        $dados = $request->validate($this->regras(true));
        $categoria->update($dados);

        return response()->json($categoria->fresh());
    }

    // DELETE /api/categorias/{id}
    public function destroy(Categoria $categoria): JsonResponse
    {
        if ($categoria->livros()->exists()) {
            return response()->json([
                'message' => 'Não é possível remover a categoria: existem livros vinculados a ela.',
            ], 409);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoria removida com sucesso.']);
    }

    private function regras(bool $atualizacao = false): array
    {
        $obrigatorio = $atualizacao ? 'sometimes' : 'required';

        return [
            'nome'      => [$obrigatorio, 'string', 'max:45'],
            'descricao' => ['nullable', 'string', 'max:255'],
        ];
    }
}
