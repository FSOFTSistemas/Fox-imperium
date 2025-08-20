<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movimento>
 */
class MovimentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'data' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'tipo' => $this->faker->randomElement(['receita', 'despesa']),
            'valor' => $this->faker->randomFloat(2, 10, 1000),
            'forma_pagamento' => $this->faker->randomElement(['dinheiro', 'cartão', 'transferência']),
            'empresa_id' => \App\Models\Empresa::factory(), // Relaciona com a empresa
        ];
    }
}
