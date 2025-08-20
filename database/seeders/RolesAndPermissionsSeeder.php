<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpar cache de permissões (garantir consistência)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Criar permissões
        Permission::create(['name' => 'acesso total']); // Exemplo: Gerenciar usuários
        Permission::create(['name' => 'view dashboard']); // Exemplo: Ver painel administrativo

        // Criar papéis
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Associar permissões ao papel admin
        $adminRole->givePermissionTo(['acesso total', 'view dashboard']);

        // Associar permissões específicas ao papel user (opcional)
        $userRole->givePermissionTo(['view dashboard']);

        $this->command->info('Papéis e permissões foram criados e relacionados com sucesso!');
    }
}
