<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Livro extends Model
{
    protected $table = 'livro';
    protected $primaryKey = 'idlivro';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'isbn',
        'anopublicacao',
        'descricao',
        'paginas',
        'idautor',
        'idcategoria',
    ];

    protected function casts(): array
    {
        return [
            'anopublicacao' => 'integer',
            'paginas' => 'integer',
            'idautor' => 'integer',
            'idcategoria' => 'integer',
        ];
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(Autor::class, 'idautor', 'idautor');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'idcategoria', 'idcategoria');
    }
}
