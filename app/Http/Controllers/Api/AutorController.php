<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AutorController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->json(Autor::orderBy('nome')->get());
    }

 
    public function show(Autor $autor): JsonResponse
    {
        return response()->json($autor->load('livros.categoria'));
    }

   
    public function store(Request $request): JsonResponse
    {
        $dados = $request->validate($this->regras());
        $autor = Autor::create($dados);

        return response()->json($autor, 201);
    }

  
    public function update(Request $request, Autor $autor): JsonResponse
    {
        $dados = $request->validate($this->regras(true));
        $autor->update($dados);

        return response()->json($autor->fresh());
    }


    public function destroy(Autor $autor): JsonResponse
    {
        if ($autor->livros()->exists()) {
            return response()->json([
                'message' => 'Não é possível remover o autor: existem livros vinculados a ele.',
            ], 409);
        }

        $autor->delete();

        return response()->json(['message' => 'Autor removido com sucesso.']);
    }

    private function regras(bool $atualizacao = false): array
    {
        $obrigatorio = $atualizacao ? 'sometimes' : 'required';

        return [
            'nome'          => [$obrigatorio, 'string', 'max:45'],
            'nacionalidade' => ['nullable', 'string', 'max:45'],
            'nascimento'    => ['nullable', 'date'],
            'biografia'     => ['nullable', 'string'],
        ];
    }
}
