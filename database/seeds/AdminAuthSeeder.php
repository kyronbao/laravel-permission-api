<?php

use Admin\Models\Stuff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stuffs = ['admin', 'user'];
        foreach ($stuffs as $key => $stuff) {
            Stuff::create([
                'id' => $key + 1,
                'username' => $stuff,
                'password' => Hash::make('12345678'),
                'admin_token' => hash('sha256', 'token_string'),
            ]);
        }

        $roles = ['super-admin', 'projector', 'coder'];
        foreach ($roles as $key => $role) {
            Role::create([
                'id' => $key + 1,
                'name' => $role,
                'guard_name' => Stuff::GUARD,
            ]);
        }

        $permissions = [[
            'id' => 1,
            'name' => 'auth management',
            'name_cn' => '授权管理',
            'parent' => 0,
            'path' => '',
            'guard_name' => Stuff::GUARD,

        ], [
            'id' => 2,
            'name' => 'stuffs management',
            'name_cn' => '员工管理',
            'parent' => 1,
            'path' => 'admin/get-stuffs',
            'guard_name' => Stuff::GUARD,

        ], [
            'id' => 3,
            'name' => 'roles management',
            'name_cn' => '角色管理',
            'parent' => 1,
            'path' => 'admin/get-roles',
            'guard_name' => Stuff::GUARD,
        ], [
            'id' => 4,
            'name' => 'permissions management',
            'name_cn' => '权限管理',
            'parent' => 1,
            'path' => 'admin/get-permissions',
            'guard_name' => Stuff::GUARD,
        ]];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $admin = Stuff::findByUsername('admin');
        $admin->syncRoles(['super-admin']);

        $user = Stuff::findByUsername('user');
        $user->syncRoles(['coder']);

        $coder = Role::findByName('coder', Stuff::GUARD);
        $coder->syncPermissions([
            'auth management',
            'stuffs management',
        ]);


    }
}
