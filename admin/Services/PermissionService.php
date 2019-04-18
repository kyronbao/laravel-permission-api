<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-25
 * Time: 下午11:15
 */

namespace Admin\Services;

use App\Traits\StaticServer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService
{

    use StaticServer;

    public $role;
    public $permission;

    public function __construct()
    {
        $this->role = new Role(['guard_name' => 'admin']);
        $this->permission = new Permission(['guard_name' => 'admin']);
    }

    /**
     * Batch Sync model
     *
     * @param $model
     * @param $params
     * @param $index
     */
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

    /**
     * Get auth Routes
     *
     * @return mixed
     */
    public function getAuthRoutes()
    {
        $stuff = Auth::guard('admin')->user();
        return $stuff->getAllPermissions()->pluck('path')->toArray();
    }

}