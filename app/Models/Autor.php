<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Autor extends Model
{
    protected $table = 'autor';
    protected $primaryKey = 'idautor';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'nacionalidade',
        'nascimento',
        'biografia',
    ];

    protected function casts(): array
    {
        return [
            'nascimento' => 'date:Y-m-d',
        ];
    }

    public function livros(): HasMany
    {
        return $this->hasMany(Livro::class, 'idautor', 'idautor');
    }
}
