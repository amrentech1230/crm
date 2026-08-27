<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function parentUser()
    {
        // Assuming parentid points to the users table id
        return $this->belongsTo(User::class, 'parent_role');
    }
}
