<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class BasicRolesSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // Contacts Module
        $permissions = [
            'view contacts',
            'create contact',
            'edit contact',
            'delete contact',
            'view wave warehouse',
            'manage store',
            'view history',
            'view wave fire',
            'manage sales CRM',
            'manage missions',
            'manage inventory'
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Wave Purchase Module
        // Permission::create(['name' => 'view wave purchase']);
        // Permission::create(['name' => 'create purchase']);
        // Permission::create(['name' => 'edit purchase']);
        // Permission::create(['name' => 'delete purchase']);

        // Wave Store SS Plus Firefighting Module
        // Permissions similar to Wave Fire Module

        // Wave Store SS Plus Equipment Module
        // Permissions similar to Wave Store SS Plus Firefighting Module

        // Wave Invoicing Module
        // Permission::create(['name' => 'view wave invoicing']);
        // Permission::create(['name' => 'manage invoices']);

        // Wave Finance Module
        // Permission::create(['name' => 'view wave finance']);
        // Permission::create(['name' => 'manage invoicing flow']);
        // Permission::create(['name' => 'manage expenses flow']);
        // Permission::create(['name' => 'manage budget flow']);

        // Wave HR Module
        // Permission::create(['name' => 'view wave HR']);
        // Permission::create(['name' => 'manage work team']);
        // Permission::create(['name' => 'manage recruitment']);
        // Permission::create(['name' => 'manage time off']);
        // Permission::create(['name' => 'conduct appraisals']);
        // Permission::create(['name' => 'manage employee time clock']);

        // Wave Report Module
        // Permission::create(['name' => 'view wave reports']);
        // Permission::create(['name' => 'generate reports']);

        // Client Portal Module
        // Permission::create(['name' => 'view client portal']);
        // Permission::create(['name' => 'access missions']);
        // Permission::create(['name' => 'view fire park']);
        // Permission::create(['name' => 'view life sheet']);
        // Permission::create(['name' => 'view sales']);
        // Permission::create(['name' => 'view invoices']);
        // Permission::create(['name' => 'manage requests and complaints']);

        // Admin Dashboard Module
        $adminPermissions = [
            'view admin dashboard',
            'configure system',
            'configure apps',
            'manage hub services'
        ];
        
        // Create admin permissions if they don't exist
        foreach ($adminPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // create roles and assign existing permissions
        $role1 = Role::firstOrCreate(['name' => 'Administrator']);
        $adminPermissions = [
            'view contacts', 'create contact', 'edit contact', 'delete contact',
            'view wave warehouse', 'manage store', 'view history',
            'view wave fire', 'manage sales CRM', 'manage missions', 'manage inventory',
            'view admin dashboard', 'configure system', 'configure apps', 'manage hub services'
        ];
        $role1->syncPermissions($adminPermissions);

        $role2 = Role::firstOrCreate(['name' => 'Manager']);
        $managerPermissions = [
            'view contacts', 'create contact', 'edit contact', 'delete contact',
            'view wave warehouse', 'manage store', 'view history',
            'view wave fire', 'manage sales CRM', 'manage missions', 'manage inventory'
        ];
        $role2->syncPermissions($managerPermissions);

        $role3 = Role::firstOrCreate(['name' => 'Client']);

        // Create or update Administrator user
        $admin = \App\Models\User::firstOrNew(['email' => 'admin@wavehub.tn']);
        if (!$admin->exists) {
            $admin->name = 'Administrator User';
            $admin->password = bcrypt('123456789');
            $admin->save();
        }
        $admin->assignRole($role1);

        // Create or update Manager user
        $manager = \App\Models\User::firstOrNew(['email' => 'manager@wavehub.tn']);
        if (!$manager->exists) {
            $manager->name = 'Manager User';
            $manager->password = bcrypt('987654321');
            $manager->save();
        }
        $manager->assignRole($role2);

        // Create or update Client user
        $client = \App\Models\User::firstOrNew(['email' => 'clienttest@wavehub.tn']);
        if (!$client->exists) {
            $client->name = 'Client Test';
            $client->password = bcrypt('987654321');
            $client->save();
        }
        $client->assignRole($role3);
    }
}
