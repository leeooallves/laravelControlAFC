<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'user_id',
        'funcao',
        'salario',
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

    public function clients(){
        return $this->hasMany(Cliente::class,'funcionarios_id');
    }
}
