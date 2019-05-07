<?php
/**
 * Created by PhpStorm.
 * User: Kenyon Bao
 * Date: 19-3-25
 * Time: 上午3:00
 */

namespace Admin\Controllers;


use Admin\Models\Stuff;
use Admin\Services\PermissionService;
use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController
{
    private $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function postRoles(Request $request)
    {
        $request->validate([
            'data' => 'required|array',
            'data.*.name' => 'required|string',
            'data.*.name_cn' => 'required|string',
            'data.*.guard_name' => 'required|string',
        ]);

        $this->service->batchSync(
            $this->service->role,
            $request->input('data'),
            'name'
        );
        return responseOk([], 'Batch post done');
    }

    public function getRoles()
    {
        return responseOk($this->service->role->get());
    }


    public function postPermissionsViaRole(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'current_permissions' => 'array',
        ]);
        $role_id = $request->input('id');
        $current_permissions = $request->input('current_permissions');
        $role = Role::findById($role_id, Stuff::GUARD);

        return responseOk($role->syncPermissions($current_permissions));
    }


    public function getPermissionsViaRole(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
        $role_id = $request->input('id');
        /** @var Role $role */
        $role = Role::findById($role_id, Stuff::GUARD);
        if ($role->isSuperAdmin()) {
            return responseOk(Permission::all());
        }
        return responseOk($role->getAllPermissions());
    }


    public function postMenusViaRole(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'current_menus' => 'required|array',
        ]);

        $role_id = $request->input('id');
        $current_menus = $request->input('current_menus');
        /** @var Role $role */
        $role = Role::findById($role_id, Stuff::GUARD);

        return responseOk($role->syncMenus($current_menus));
    }

    public function getMenusViaRole(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $role_id = $request->input('id');
        /** @var Role $role */
        $role = Role::findById($role_id, Stuff::GUARD);
        return responseOk($role->getMenusViaRole());
    }


    public function postPermissions(Request $request)
    {
        $request->validate([
            'data' => 'required|array',
            'data.*.name' => 'required|string',
            'data.*.name_cn' => 'required|string',
            'data.*.guard_name' => 'required|string',
            'data.*.path' => 'required|string',
        ]);
        $this->service->batchSync(
            $this->service->permission,
            $request->input('data'),
            'name'
        );
        return responseOk([], 'Batch post done');
    }

    public function getPermissions()
    {
        return responseOk($this->service->permission->get());
    }


    public function getMenu()
    {
        return responseOk($this->service->menu->getMenuTree());
    }

    public function getMenus()
    {
        return responseOk($this->service->menu->get());
    }

    public function postMenus(Request $request)
    {
        $request->validate([
            'data' => 'required|array',
            'data.*.name' => 'required|string',
            'data.*.name_cn' => 'required|string',
            'data.*.parent' => 'required|integer',
        ]);
        $this->service->batchSync(
            $this->service->menu,
            $request->input('data'),
            'name'
        );
        return responseOk([], 'Batch post done');
    }


    public function getStuffs()
    {
        return responseOk($this->service->stuff->get());
    }

    public function deleteStuff(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->input('id');
        return responseOk($this->service->stuff->findOrFail($id)->forceDelete());
    }

    public function postRolesViaStuff(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'current_roles' => 'required|array',
        ]);

        $stuff = Stuff::findOrFail($request->input('id'));
        $roles = $request->input('current_roles');

        return responseOk($stuff->syncRoles($roles));
    }

    public function getRolesViaStuff(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        /** @var Stuff $stuff */
        $stuff = Stuff::findOrFail($request->input('id'));

        return responseOk($stuff->roles);
    }

}