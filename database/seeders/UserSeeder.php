<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'administrador',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'is_permission' => 'admin',
        ]);

        $funcionario = \App\Models\User::factory()->create([
            'name' => 'funcionario',
            'email' => 'funcionario@funcionario.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'is_permission' => 'funcionario',
        ]);
        \App\Models\Funcionario::factory()->create([
            'user_id' => $funcionario,
            'nome' => 'funcionario',
            'funcao' => '**********',
            'salario' => 1200,
            'telefone' => '00000000000',
            'cep' => '00000000',
            'endereco' => '************* *******',
            'numero' => '****',
            'bairro' => '****',
            'cidade' => '****',
            'estado' => '****',
        ]);

        $cliente = \App\Models\User::factory()->create([
            'name' => 'cliente',
            'email' => 'cliente@cliente.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'is_permission' => 'cliente',
        ]);

        \App\Models\Cliente::factory()->create([
            'user_id' => $cliente,
            'funcionarios_id'=> $funcionario,
            'tipo' => 'pf',
            'nome' => 'cliente',
            'telefone' => '00000000000',
            'cep' => '00000000',
            'endereco' => '************* *******',
            'numero' => '****',
            'bairro' => '****',
            'cidade' => '****',
            'estado' => '****',
        ]);
    }
}
