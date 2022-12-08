<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    private $cliente;
    public function __construct()
    {
        $this->cliente = (new Cliente);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $client = $this->cliente->where('user_id', '=', $user->id)->first();
        return response()->json([$client], 200);
    }

    public function edit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tipo' => ['required', 'in:pf,pj'],
            'nome' => ['string'],
            'telefone' => ['nullable', 'max:18'],
            'cep' => ['nullable', 'max:8'],
            'endereco' => ['nullable', 'string'],
            'numero' => ['nullable', 'string'],
            'bairro' => ['nullable', 'string'],
            'cidade' => ['nullable', 'string'],
            'estado' => ['nullable', 'string', 'max:2']
        ], [
            'tipo' => 'obrigatório tipo string [pf/pj]',
            'nome' => 'string',
            'telefone' => 'nulo ou  maximo 18 caracteres',
            'cep' => 'nulo ou  maximo 8 caracteres',
            'endereco' => 'nulo ou string',
            'numero' => 'nulo ou string',
            'bairro' => 'nulo ou string',
            'cidade' => 'nulo ou string',
            'estado' => 'nulo, string ou  maximo 2 caracteres'
        ]);
        $validatedData = $validator->fails();

        if ($validatedData) {
            return response()->json([
                'status' => '403',
                'message' => $validator->messages(),
                'records' => null
            ]);
            exit;
        }

        $update = $this->cliente->with('user:id,name')->findOrfail(1);
        $update->update($request->all());
        return response()->json([
            'status' => '200',
            'message' => 'sucesso',
            'records' => $update
        ]);
    }
}
