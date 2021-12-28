<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\{Database\Seeder, Support\Facades\Hash};
use Spatie\Permission\Models\{Permission, Role};
use Spatie\Permission\PermissionRegistrar;


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
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

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
            ['name' => 'edit_company'], //Adicionar e Remover usuários(funcionários)
            ['name' => 'edit_employee'], //Adicionar e Remover usuários(funcionários)

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
        foreach (Permission::whereNotIn('name', ['edit_scheduling', 'edit_client'])->get() as $item) {
            $dataAdmin[] = $item->name;
        }
        $admin->givePermissionTo($dataAdmin);

        // Responsável por Gerir o sistema: Gerente
        $manager = Role::create(['name' => 'manager']);
        $dataManager = [];
        foreach (Permission::whereNotIn('name', ['edit_user', 'audit_user', 'edit_company'])->get() as $item) {
            $dataManager[] = $item->name;
        }
        $manager->givePermissionTo($dataManager);

        //Responsável por gerir clientes: Funcionários
        $employees = Role::create(['name' => 'employees']);
        $dataEditor = [];
        foreach (Permission::whereNotIn('name', ['view_analytics', 'edit_user', 'audit_user', 'edit_company', 'edit_employee', 'view_analytic'])->get() as $item) {
            $dataEditor[] = $item->name;
        }
        $employees->givePermissionTo($dataEditor);


        //Role::create(['name' => 'client']);

        if (config('APP_ENV') != "production") {
            $gadmin = User::factory()->create([
                'name' => 'GAdmin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin'),
                //'adm' => true
            ]);
            $gadmin->assignRole($admin);

            $gemployee = User::factory()->create([
                'name' => 'GFunc',
                'email' => 'func@example.com',
                'password' => Hash::make('admin'),
                //'adm' => true
            ]);
            $gemployee->assignRole($employees);

            $gmanager = User::factory()->create([
                'name' => 'GManager',
                'email' => 'manager@example.com',
                'password' => Hash::make('admin'),
                //'adm' => true
            ]);
            $gmanager->assignRole($manager);
        }
    }

}
