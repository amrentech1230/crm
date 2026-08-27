<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
