<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livro', function (Blueprint $table) {
            $table->increments('idlivro');
            $table->string('titulo', 255);
            $table->string('isbn', 45)->nullable()->unique();
            $table->integer('anopublicacao')->nullable();
            $table->string('descricao', 255)->nullable();
            $table->integer('paginas')->nullable();
            $table->unsignedInteger('idautor');
            $table->unsignedInteger('idcategoria');

            // Relacionamentos (1 autor -> N livros | 1 categoria -> N livros)
            $table->foreign('idautor')
                ->references('idautor')->on('autor')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('idcategoria')
                ->references('idcategoria')->on('categoria')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livro');
    }
};
