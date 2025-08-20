<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
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
            'precocusto' => $this->faker->randomFloat(2, 1, 100),
            'precovenda' => $this->faker->randomFloat(2, 1, 200),
            'estoque' => $this->faker->numberBetween(1, 100),
            'empresa_id' => \App\Models\Empresa::factory(), // Relaciona com a empresa
        ];
    }
}
