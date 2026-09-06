<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'load_id',
        'customer_id',
        'message',
        'user_name',
        'user_id',
        'user_email',
        'old_json',
        'new_json',
        'ip',
        'url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
