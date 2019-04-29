<?php

namespace App\Models;


class Permission extends \Spatie\Permission\Models\Permission
{
    public $fillable = [
        'name',
        'name_cn',
        'guard_name',
        'path',
    ];
}
