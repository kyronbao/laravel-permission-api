<?php

use Admin\Models\Menu;
use Admin\Models\Stuff;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

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
                'email' => $stuff . '@admin.com',
                'password' => Hash::make('12345678'),
                'admin_token' => hash('sha256', 'token_string'),
            ]);
        }

        $roles = [['super-admin', '超级管理'], ['projector', '项目经理'], ['coder', '码农']];
        foreach ($roles as $key => $role) {
            Role::create([
                'id' => $key + 1,
                'name' => $role[0],
                'name_cn' => $role[1],
                'guard_name' => Stuff::GUARD,
            ]);
        }

        $permissions = [[
            'id' => 1,
            'name' => 'get stuffs',
            'name_cn' => '获取员工',
            'path' => 'admin/auth/get-stuffs',
            'guard_name' => Stuff::GUARD,

        ], [
            'id' => 2,
            'name' => 'get roles',
            'name_cn' => '获取角色',
            'path' => 'admin/auth/get-roles',
            'guard_name' => Stuff::GUARD,
        ], [
            'id' => 3,
            'name' => 'get permissions',
            'name_cn' => '获取权限',
            'path' => 'admin/auth/get-permissions',
            'guard_name' => Stuff::GUARD,
        ], [
            'id' => 4,
            'name' => 'get menus',
            'name_cn' => '获取菜单',
            'path' => 'admin/auth/get-stuffs',
            'guard_name' => Stuff::GUARD,
        ]];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $menus = [[
            'id' => 1,
            'name' => 'auth management',
            'name_cn' => '授权管理',
            'parent' => 0,
            'path' => '/',
        ], [
            'id' => 2,
            'name' => 'stuffs management',
            'name_cn' => '员工管理',
            'parent' => 1,
            'path' => 'auth/stuffs',
        ], [
            'id' => 3,
            'name' => 'roles management',
            'name_cn' => '角色管理',
            'parent' => 1,
            'path' => 'auth/roles',
        ], [
            'id' => 4,
            'name' => 'permissions management',
            'name_cn' => '权限管理',
            'parent' => 1,
            'path' => 'auth/permissions',
        ], [
            'id' => 5,
            'name' => 'menus management',
            'name_cn' => '菜单管理',
            'parent' => 1,
            'path' => 'auth/menus',
        ]];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        $admin = Stuff::findByUsername('admin');
        $admin->syncRoles(['super-admin']);

        $user = Stuff::findByUsername('user');
        $user->syncRoles(['coder']);

        /** @var Role $coder */
        $coder = Role::findByName('coder', Stuff::GUARD);
        $coder->syncPermissions([
            'get stuffs',
            'get roles',
        ]);
        $coder->syncMenus([1, 2, 3]);


    }
}
