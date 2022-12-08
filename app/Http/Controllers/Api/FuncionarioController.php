<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Funcionario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FuncionarioController extends Controller
{
    private $funcionario;

    public function __construct(Funcionario $funcionario)
    {
        $this->funcionario = $funcionario;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $funcionario = $this->funcionario->where('user_id', '=', $user->id)->first();
        return response()->json(['record' => $funcionario], 200);
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => ['string'],
            'telefone' => ['nullable', 'max:18'],
            'funcao' => ['nullable'],
            'salario' => ['nullable'],
            'cep' => ['nullable', 'max:8'],
            'endereco' => ['nullable', 'string'],
            'numero' => ['nullable', 'string'],
            'bairro' => ['nullable', 'string'],
            'cidade' => ['nullable', 'string'],
            'estado' => ['nullable', 'string', 'max:2']
        ], [
            'nome' => 'string',
            'telefone' => 'nulo ou  maximo 18 caracteres',
            'funcao' => 'string',
            'salario' => 'decimal 10,2',
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
        }

        $update = $this->funcionario->with('user:id,name')->findOrfail(1);
        $update->update($request->all());
        return response()->json([
            'status' => '200',
            'message' => 'sucesso',
            'records' => $update
        ]);
    }

    // Cliente
    public function showClient(Request $request)
    {
        $user = $request->user();
        $client = (new Cliente())->where('funcionarios_id', '=', $user->id)->get();
        return response()->json(['records' => $client], 200);
    }

    public function findClient($id, Request $request)
    {
        $user = $request->user();

        $client = (new Cliente())->where('funcionarios_id', '=', $user->id)
            ->where('id', '=', $id)
            ->first();
        if (!$client) {
            return response()->json(['message' => 'usuário não encontrado.', 'record' => null], 302);
        }
        return response()->json(['record' => $client], 200);
    }

    public function storeClient(Request $request)
    {
        $user        = $request->user();
        $data_user   = $request->only('name', 'email', 'password');
        $data_user['password'] = bcrypt($data_user['password']);
        $data_client = $request->only('tipo', 'telefone', 'cep', 'endereco', 'numero', 'bairro', 'cidade', 'estado');

        // validate user
        $validator = Validator::make($data_user, [
            'email' => 'unique:users,email'
        ], [
            'email.unique' => 'erro FC L:107',
        ]);
        $validatedData = $validator->fails();
        if ($validatedData) {
            return response()->json([
                'status' => '403',
                'message' => $validator->messages(),
                'records' => null
            ]);
        }

        // validate client
        $validator = Validator::make($data_client, [
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
        // create user
        $userStore = User::create($data_user);
        if ($userStore) {
            // add attributes
            $data_client['funcionarios_id'] = $user->id;
            $data_client['nome'] = $user->name;
            $data_client['user_id'] = $userStore->id;
            // create client
            $clientStore = Cliente::create($data_client);
            if (!$clientStore) {
                DB::rollback();
                return response()->json(['mesage' => 'Erro POST CREATE'], 302);
            }
            return response()->json($clientStore, 200);
        } else {
            DB::rollback();
        }
    }
    public function editClient($client_id, Request $request)
    {

        // validate client
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
        }

        $user = $request->user();
        $updateClient = Cliente::where('funcionarios_id', '=', $user->id)
            ->where()->update($request->all());

        return response()->json(['record' => $updateClient], 200);
    }
    public function destroyClient($client_id, Request $request)
    {
        $user = $request->user();
        $client = Cliente::where('funcionarios_id', '=', $user->id)
            ->where('id', '=', $client_id)->first();


        if (!$client) {
            return response()->json(['record' => null, 'message' => 'Ops, o registro não existe.'], 302);
        }

        User::destroy($client->user_id);
        Cliente::destroy($client->id);

        return response()->json(['mesasge' => 'success', 'record' => true], 200);
    }
}
