<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Livro;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LivroController extends Controller
{
    // GET /api/livros  (filtros opcionais: ?idautor=1&idcategoria=2)
    public function index(Request $request): JsonResponse
    {
        $livros = Livro::with(['autor', 'categoria'])
            ->when($request->query('idautor'), fn ($q, $v) => $q->where('idautor', $v))
            ->when($request->query('idcategoria'), fn ($q, $v) => $q->where('idcategoria', $v))
            ->orderBy('titulo')
            ->get();

        return response()->json($livros);
    }

    // GET /api/livros/{id}
    public function show(Livro $livro): JsonResponse
    {
        return response()->json($livro->load(['autor', 'categoria']));
    }

    // POST /api/livros
    public function store(Request $request): JsonResponse
    {
        $dados = $request->validate($this->regras());
        $livro = Livro::create($dados);

        return response()->json($livro->load(['autor', 'categoria']), 201);
    }

    // PUT /api/livros/{id}
    public function update(Request $request, Livro $livro): JsonResponse
    {
        $dados = $request->validate($this->regras($livro));
        $livro->update($dados);

        return response()->json($livro->fresh(['autor', 'categoria']));
    }

    // DELETE /api/livros/{id}
    public function destroy(Livro $livro): JsonResponse
    {
        $livro->delete();

        return response()->json(['message' => 'Livro removido com sucesso.']);
    }

    private function regras(?Livro $livro = null): array
    {
        $obrigatorio = $livro ? 'sometimes' : 'required';

        $isbnUnico = Rule::unique('livro', 'isbn');
        if ($livro) {
            $isbnUnico->ignore($livro->idlivro, 'idlivro');
        }

        return [
            'titulo'        => [$obrigatorio, 'string', 'max:255'],
            'isbn'          => ['nullable', 'string', 'max:45', $isbnUnico],
            'anopublicacao' => ['nullable', 'integer', 'min:0', 'max:' . (date('Y') + 1)],
            'descricao'     => ['nullable', 'string', 'max:255'],
            'paginas'       => ['nullable', 'integer', 'min:1'],
            'idautor'       => [$obrigatorio, 'integer', 'exists:autor,idautor'],
            'idcategoria'   => [$obrigatorio, 'integer', 'exists:categoria,idcategoria'],
        ];
    }
}
