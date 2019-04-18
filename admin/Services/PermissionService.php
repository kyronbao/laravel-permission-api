<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-25
 * Time: 下午11:15
 */

namespace Admin\Services;

use Admin\Models\Menu;
use Admin\Models\Stuff;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService extends BaseService
{

    public $role;
    public $permission;

    public function __construct()
    {
        $this->role = new Role(['guard_name' => 'admin']);
        $this->permission = new Permission(['guard_name' => 'admin']);
    }

    public function postRoles(Request $request)
    {
        $this->batchSync($this->role, $request->all(), 'name');
        return responseOk([], 'Batch post done');
    }

    public function batchSync($model, $params, $index)
    {
        $keys = array_keys($params[0]);
        $params_value = Arr::pluck($params, $index);

        $olds = $model->get($keys)->toArray();
        $olds_value = Arr::pluck($olds, $index);

        $delete = [];

        foreach ($olds as $item) {
            if (!in_array($item[$index], $params_value)) {
                array_push($delete, $item);
            }
        }

        $model->whereIn($index, Arr::pluck($delete, $index))->delete();

        foreach ($params as $item) {
            if (in_array($item[$index], $olds_value)) {

                $update_model = $model->where($index, $item[$index])->first();
                foreach ($item as $key => $value) {
                    $update_model->$key = $value;
                }
                $update_model->update();
            } else {
                $model->create($item);
            }
        }

    }

    public function getRoles()
    {
        return responseOk($this->role->get());
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

    public function getAuthRoutes()
    {
        $stuff = Auth::guard('admin')->user();
        return $stuff->getAllPermissions()->pluck('path')->toArray();
    }


    public function postPermissions(Request $request)
    {
        $this->batchSync($this->permission, $request->all(), 'name');
        return responseOk([], 'Batch post done');
    }

    public function getPermissions()
    {
        $permissins = $this->permission->get();
        return responseOk($permissins);
    }


    public function postRolesViaUser(Request $request)
    {
        $stuff = Stuff::find($request->input('stuff_id'));
        $roles = $request->input('roles');

        return $stuff->syncRoles($roles);
    }

    public function getRolesViaUser(Request $request)
    {
        /** @var Stuff $stuff */
        $stuff = Stuff::findOrFail($request->input('id'));

        return responseOk($stuff->roles);
    }


    public function getMenus()
    {
        return responseOk((new Menu)->getMenuTree());
    }


}