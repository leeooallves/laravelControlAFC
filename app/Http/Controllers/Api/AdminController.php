<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminCollection;
use App\Models\Cliente;
use App\Models\Funcionario;
use App\Models\User;
use App\Models\UserisPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Model User
     *
     * @var \Model\User
     */
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $record = $this->user->where('is_permission', '=', 'admin')->get();
        return response()->json(new AdminCollection($record), 200);
    }

    public function show($id, Request $request)
    {
        $record = (new User())->where('is_permission', '=', 'admin')->where('id', '=', $id)->get();
        return response()->json(new AdminCollection($record), 200);
    }

    public function store(Request $request)
    {
        $data_user = $request->only('name', 'email', 'password');
        $data_user['password'] = bcrypt($data_user['password']);
        // validate user
        $validator = Validator::make($data_user, [
            'email' => 'unique:users,email'
        ], [
            'email.unique' => 'erro FC L:107', // FC = Falha no Controller | L = linha

        ]);
        $validatedData = $validator->fails();
        if ($validatedData) {
            return response()->json([
                'status' => '403',
                'message' => $validator->messages(),
                'records' => null
            ]);
        }

        $data_user['is_permission'] = 'admin';
        $userCreate = UserisPermission::create($data_user);
        return response()->json($userCreate, 200);
    }
    public function edit($id, Request $request)
    {
        $user = $request->user();
        $data_user = $request->only('name', 'email', 'password');
        $data_user['password'] = bcrypt($data_user['password']);

        if ($user->email != $data_user['email']) {
            // validate user
            $validator = Validator::make($data_user, [
                'email' => 'unique:users,email'
            ], [
                'email.unique' => 'erro FC L:107', // FC = Falha no Controller | L = linha

            ]);

            $validatedData = $validator->fails();
            if ($validatedData) {
                return response()->json([
                    'status' => '403',
                    'message' => "Não e possível efetur a edição, e-mail já existe.",
                    'records' => null
                ]);
            }
        }
        $userUpdate = User::find($id)->update($data_user);
        return response()->json(['record' => $userUpdate], 200);
    }


    // MODULO DE FUNCIONÁRIOS
    // CRUD
    public function indexFuncionario(Request $request)
    {
        $funcionarios = Funcionario::all();
        return response()->json(['record' => $funcionarios], 200);
    }

    public function showFuncionario($id, Request $request)
    {
        $funcionario = Funcionario::find($id);
        return response()->json(['record' => $funcionario], 200);
    }

    public function storeFuncionario(Request $request)
    {

        $data_user = $request->only('name', 'email', 'password');
        $data_user['password'] = bcrypt($data_user['password']);
        $data_funcionario = $request->only('telefone', 'funcao', 'salario', 'cep', 'endereco', 'numero', 'bairro', 'cidade', 'estado');

        $validator = Validator::make($data_user, [
            'name' => 'required',
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

        $validator = Validator::make($data_funcionario, [
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

        // create user
        $userStore = User::create($data_user);
        if ($userStore) {
            // add attributes
            $data_funcionario['nome'] = $data_user['name'];
            $data_funcionario['user_id'] = $userStore->id;
            $data_funcionario['is_permission'] = 'funcionario';
            // create client
            $funcionarioStore = Funcionario::create($data_funcionario);
            if (!$funcionarioStore) {
                DB::rollback();
                return response()->json(['mesage' => 'Erro POST CREATE'], 302);
            }
            return response()->json($funcionarioStore, 200);
        } else {
            DB::rollback();
        }

        $update = Funcionario::with('user:id,name')->findOrfail(1);
        $update->update($request->all());
        return response()->json([
            'status' => '200',
            'message' => 'sucesso',
            'records' => $update
        ]);
    }

    // edit funcionario
    public function editFuncionario($id, Request $request)
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


        $funcionarioUpdate = Funcionario::find($id)->update($request->all());
        if (!$funcionarioUpdate) {
            return response()->json([
                'status' => '403',
                'message' => "Erro ao atualizar",
                'records' => null
            ]);
        }

        return response()->json(['record' => $funcionarioUpdate], 200);
    }

    public function destroyFuncionario($id, Request $request)
    {
        $dadosFuncionario = Funcionario::where('id', '=', $id)->first();

        if (!$dadosFuncionario) {
            return response()->json(['message' => 'erro'], 302);
        }

        $clientes = Cliente::where('funcionarios_id', $id)->delete();
        Funcionario::destroy($id);
        User::destroy($dadosFuncionario->user_id);
        return response()->json(['record' => true], 200);
    }



    // MODULO DE CLIENTES
    // CRUD
    public function indexCliente($id, Request $request)
    {
        $clients = Cliente::where('funcionarios_id', '=', $id)->get();
        if ($clients) {
            return response()->json(['records' => $clients], 200);
        }

        return response()->json(['records' => null, 'message' => 'erro'], 200);
    }

    // criar
    public function storeCliente($id, Request $request)
    {

        $funcionario = Funcionario::where('id', $id)->get();
        if (!$funcionario) {
            return response()->json([
                'status' => '403',
                'message' => "erro",
                'records' => null
            ]);
        }

        $data_user = $request->only('name', 'email', 'password');
        $data_user['password'] = bcrypt($data_user['password']);
        $data_client = $request->only('tipo', 'telefone', 'cep', 'endereco', 'numero', 'bairro', 'cidade', 'estado');

        $validator = Validator::make($data_user, [
            'name' => 'required',
            'email' => 'unique:users,email'
        ], [
            'email.unique' => 'o e-mail já existe.',
        ]);

        $validatedData = $validator->fails();
        if ($validatedData) {
            return response()->json([
                'status' => '403',
                'message' => $validator->messages(),
                'records' => null
            ], 403);
        }

        $validator = Validator::make($data_client, [
            'tipo' => ['required', 'in:pf,pj'],
            'telefone' => ['nullable', 'max:18'],
            'cep' => ['nullable', 'max:8'],
            'endereco' => ['nullable', 'string'],
            'numero' => ['nullable', 'string'],
            'bairro' => ['nullable', 'string'],
            'cidade' => ['nullable', 'string'],
            'estado' => ['nullable', 'string', 'max:2']
        ], [
            'tipo' => 'obrigatório tipo string [pf/pj]',
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

        // create user
        $data_user['is_permission'] = 'cliente';
        $userStore = UserisPermission::create($data_user);
        if ($userStore) {
            // add attributes
            $data_client['nome'] = $data_user['name'];
            $data_client['user_id'] = $userStore->id;
            $data_client['funcionarios_id'] = $id;
            // create client
            $clienteStore = Cliente::create($data_client);
            if (!$clienteStore) {
                DB::rollback();
                return response()->json(['mesage' => 'Erro POST CREATE'], 302);
            }
            return response()->json($clienteStore, 200);
        } else {
            DB::rollback();
        }



        $update = Cliente::with('user:id,name')->findOrfail($id);
        $update->update($request->all());
        return response()->json([
            'status' => '200',
            'message' => 'sucesso',
            'records' => $update
        ]);
    }


    public function editCliente($id, $client_id, Request $request)
    {
        $funcionario = Funcionario::find($id);
        if (!$funcionario) {
            return response()->json([
                'status' => '403',
                'message' => "funcionário não existe.",
                'records' => null
            ]);
        }
        $cliente = Cliente::where('funcionarios_id', '=', $id)->where('id', $client_id)->get();
        $data_cliente = $request->only('tipo', 'telefone', 'cep', 'endereco', 'numero', 'bairro', 'cidade', 'estado');

        $validator = Validator::make($data_cliente, [
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
        $update = Cliente::with('user:id,name')->findOrfail($client_id);
        $update->update($data_cliente);
        return response()->json([
            'status' => '200',
            'message' => 'sucesso',
            'records' => $update
        ]);
    }


    public function destroyCliente($id, $client_id, Request $request)
    {
        $dataCliente = Cliente::find($client_id);
        if (!$dataCliente) {
            return response()->json([
                'status' => '403',
                'message' => "cliente não existe.",
                'records' => null
            ]);
        }

        Cliente::destroy($dataCliente->id);
        User::destroy($dataCliente->user_id);
        return response()->json([
            'status' => '200',
            'message' => 'sucesso',
            'records' => null
        ]);
    }
}
