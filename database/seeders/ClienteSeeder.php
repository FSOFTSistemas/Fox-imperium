<?php

namespace Database\Seeders;

use App\Models\cliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        cliente::factory()->count(10)->create();
    }
}
