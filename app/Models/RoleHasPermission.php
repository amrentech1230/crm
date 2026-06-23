<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;

class RoleHasPermission extends Model
{
    public function permissions()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
