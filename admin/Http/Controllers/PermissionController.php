<?php
/**
 * Created by PhpStorm.
 * User: Kenyon Bao
 * Date: 19-3-25
 * Time: 上午3:00
 */

namespace Admin\Http\Controllers;


use Admin\Models\Menu;
use Admin\Models\Stuff;
use Admin\Services\PermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PermissionController
{
    private $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function postRoles(Request $request)
    {
        $this->service->batchSync(
            $this->service->role,
            $request->all(),
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
        $role_id = $request->input('id');
        $current_permissions = $request->input('current_permissions');
        $role = Role::findById($role_id, Stuff::GUARD);

        return responseOk($role->syncPermissions($current_permissions));
    }


    public function getPermissionsViaRole(Request $request)
    {
        $role_id = $request->input('id');
        /** @var Role $role */
        $role = Role::findById($role_id, Stuff::GUARD);
        return responseOk($role->getAllPermissions());
    }


    public function postPermissions(Request $request)
    {
        $this->service->batchSync(
            $this->service->permission,
            $request->all(),
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
        return responseOk((new Menu)->getMenuTree());
    }


    public function getStuffs()
    {
        return responseOk($this->service->stuff->get());
    }

    public function deleteStuff(Request $request)
    {
        $id = $request->input('id');
        return responseOk($this->service->stuff->findOrFail($id)->forceDelete());
    }

    public function postRolesViaUser(Request $request)
    {
        $stuff = Stuff::find($request->input('stuff_id'));
        $roles = $request->input('roles');

        return responseOk($stuff->syncRoles($roles));
    }

    public function getRolesViaUser(Request $request)
    {
        /** @var Stuff $stuff */
        $stuff = Stuff::findOrFail($request->input('id'));

        return responseOk($stuff->roles);
    }

}