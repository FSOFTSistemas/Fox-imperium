<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresa>
 */
class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'razao_social' => $this->faker->company,
            'fantasia' => $this->faker->companySuffix,
            'cnpj' => $this->faker->unique()->numerify('##.###.###/####-##'),
            'IE' => $this->faker->numerify('###.###.###.###'),
            'email' => $this->faker->unique()->safeEmail,
            'telefone' => $this->faker->phoneNumber,
            'endereco' => $this->faker->streetAddress,
            'cidade' => $this->faker->city,
            'estado' => $this->faker->stateAbbr,
            'cep' => $this->faker->postcode,
        ];
    }
}
