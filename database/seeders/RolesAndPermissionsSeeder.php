<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        /**
         * Permissões
         */
        $permissions = [
            ['name' => 'edit_client'], //Adiciona e remove Clientes
            ['name' => 'edit_status'], //Adiciona e Remove Status dos Clientes
            ['name' => 'edit_scheduling'], //Adiciona e Remove Agendamentos
            ['name' => 'edit_pendency'], //Adiciona e Remove Pendencias
            ['name' => 'audit_user'], //Audita Usuários
            ['name' => 'view_analytic'], //Quantidades de Vendas e Valores
            ['name' => 'edit_user'], //Adicionar e Remover usuários(funcionários)

        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        /**
         * Funções/Roles
         */

        // Responsável por Gerir o sistema: Administrador
        $admin = Role::create(['name' => 'admin']);
        $dataAdmin = [];
        foreach (Permission::all() as $item) {
            $dataAdmin[] = $item->name;
        }
        $admin->givePermissionTo($dataAdmin);

        // Responsável por Gerir o sistema: Gerente
        $manager = Role::create(['name' => 'manager']);
        $dataManager = [];
        foreach (Permission::all() as $item) {
            $dataManager[] = $item->name;
        }
        $manager->givePermissionTo($dataAdmin);

        //Responsável por gerir clientes: Funcionários
        $editor = Role::create(['name' => 'employees']);
        $dataEditor = [];
        foreach (Permission::whereNotIn('name', ['view_analytics', 'edit_user','audit_user'])->get() as $item) {
            $dataEditor[] = $item->name;
        }
        $editor->givePermissionTo($dataEditor);



        //Role::create(['name' => 'client']);

        //if(config('APP_ENV')!= "production") {
            $user = \App\Models\User::factory()->create([
                'name' => 'GAdmin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin'),
                //'adm' => true
            ]);
            $user->assignRole($admin);
        //}
    }

}
