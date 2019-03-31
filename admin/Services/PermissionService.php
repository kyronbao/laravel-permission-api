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
        return $this->batchSync($this->role, $request->all(), 'name');
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

        return $this->outputSuccess([], 'Batch post done');
    }

    public function getRoles()
    {
        return $this->outputSuccess($this->role->get());
    }

    public function postRoutes(Request $request)
    {
        return $this->batchSync($this->permission, $request->all(), 'name');
    }

    public function getMenus()
    {
        return $this->outputSuccess((new Menu)->getMenuRows());
    }

    public function postRolesViaUser(Request $request)
    {
        $stuff = Stuff::find($request->input('stuff_id'));
        $roles = $request->input('roles');

        return $stuff->syncRoles($roles);
    }

    public function postRoutesViaRole(Request $request)
    {
        $role_name = $request->input('role');
        $routes = $request->input('routes');
        $role = Role::findByName($role_name);

        return $role->syncPermissions($routes);
    }


    public function getAuthRoutes()
    {
        $stuff = Auth::guard('admin')->user();
        return $stuff->getAllPermissions()->pluck('path')->toArray();
    }

}