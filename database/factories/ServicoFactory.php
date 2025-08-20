<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Servico>
 */
class ServicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descricao' => $this->faker->word,
            'preco' => $this->faker->randomFloat(2, 10, 500),
            'empresa_id' => \App\Models\Empresa::factory(), // Relaciona com a empresa
        ];
    }
}
