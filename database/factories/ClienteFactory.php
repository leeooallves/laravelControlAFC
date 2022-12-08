<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $is_type = ['pj', 'pf'];
        return [
            'tipo' => $is_type[rand(0, 1)],
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
