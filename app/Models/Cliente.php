<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tipo',
        'user_id',
        'funcionarios_id',
        'nome',
        'telefone',
        'cep',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
