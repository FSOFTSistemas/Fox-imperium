<?php

namespace Database\Seeders;

use App\Models\Movimento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movimento::factory()->count(10)->create();
    }
}
