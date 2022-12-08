<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Funcionario>
 */
class FuncionarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'funcao' => fake()->name(),
            'salario' => fake()->randomFloat(2),
            'nome' => fake()->name(),
            'telefone' => '00000000000',
            'cep' => fake('pt_BR')->postcode(),
            'endereco' => fake()->name(),
            'numero' => fake()->name(),
            'bairro' => fake()->name(),
            'cidade' => fake()->name(),
            'estado' => fake()->name(),
        ];
    }
}
