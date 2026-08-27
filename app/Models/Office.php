<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
