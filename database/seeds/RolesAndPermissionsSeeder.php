<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

        // create permissions
        // Permission::create(['name' => 'edit articles']);
        // Permission::create(['name' => 'delete articles']);
        // Permission::create(['name' => 'publish articles']);
        // Permission::create(['name' => 'unpublish articles']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $merchant_role = Role::create(['name' => 'merchant']);
        $consumer_role = Role::create(['name' => 'consumer']);
        // $merchant_role->givePermissionTo('edit articles');

        // create merchant user then assign him to merchant role
        $merchant = User::create([
            'name' => 'Merchant',
            'email' => 'merchant@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $merchant->assignRole($merchant_role);

        // create consumer user then assign him to consumer role
        $consumer = User::create([
            'name' => 'Consumer',
            'email' => 'consumer@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $consumer->assignRole($consumer_role);

    }
}
