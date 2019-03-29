<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $fillable = [
        'path',
        'key',
        'name',
        'icon',
        'parent'
    ];
}
