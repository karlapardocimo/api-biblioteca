<?php

namespace Database\Seeders;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@exemplo.com',
            'password' => 'password123',
        ]);

        $romance = Categoria::create(['nome' => 'Romance', 'descricao' => 'Obras de ficção em prosa.']);
        $poesia  = Categoria::create(['nome' => 'Poesia', 'descricao' => 'Obras em verso.']);

        $machado = Autor::create([
            'nome'          => 'Machado de Assis',
            'nacionalidade' => 'Brasileira',
            'nascimento'    => '1839-06-21',
            'biografia'     => 'Fundador da Academia Brasileira de Letras.',
        ]);

        $clarice = Autor::create([
            'nome'          => 'Clarice Lispector',
            'nacionalidade' => 'Brasileira',
            'nascimento'    => '1920-12-10',
            'biografia'     => 'Escritora e jornalista, referência da literatura moderna brasileira.',
        ]);

        $drummond = Autor::create([
            'nome'          => 'Carlos Drummond de Andrade',
            'nacionalidade' => 'Brasileira',
            'nascimento'    => '1902-10-31',
            'biografia'     => 'Poeta mineiro nascido em Itabira.',
        ]);

        // ISBNs abaixo são fictícios, apenas para teste
        Livro::create([
            'titulo' => 'Dom Casmurro', 'isbn' => '000-00-0000-001-0', 'anopublicacao' => 1899,
            'descricao' => 'Bentinho narra sua história com Capitu.', 'paginas' => 256,
            'idautor' => $machado->idautor, 'idcategoria' => $romance->idcategoria,
        ]);

        Livro::create([
            'titulo' => 'Memórias Póstumas de Brás Cubas', 'isbn' => '000-00-0000-002-0', 'anopublicacao' => 1881,
            'descricao' => 'Um defunto autor narra a própria vida.', 'paginas' => 240,
            'idautor' => $machado->idautor, 'idcategoria' => $romance->idcategoria,
        ]);

        Livro::create([
            'titulo' => 'A Hora da Estrela', 'isbn' => '000-00-0000-003-0', 'anopublicacao' => 1977,
            'descricao' => 'A história de Macabéa no Rio de Janeiro.', 'paginas' => 88,
            'idautor' => $clarice->idautor, 'idcategoria' => $romance->idcategoria,
        ]);

        Livro::create([
            'titulo' => 'A Rosa do Povo', 'isbn' => '000-00-0000-004-0', 'anopublicacao' => 1945,
            'descricao' => 'Coletânea de poemas.', 'paginas' => 200,
            'idautor' => $drummond->idautor, 'idcategoria' => $poesia->idcategoria,
        ]);
    }
}
