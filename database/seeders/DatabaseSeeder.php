<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            EmpresaSeeder::class,
            // FornecedorSeeder::class,
            PlanoDeContasSeeder::class,
            // ProdutoSeeder::class,
            // ServicoSeeder::class,
            // MovimentoSeeder::class,
            // ClienteSeeder::class,
        ]);

        $role = Role::firstOrCreate(['name' => 'admin']);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'empresa_id' => 1,
            'role' => 'admin',
        ])->assignRole($role);

    }
}
