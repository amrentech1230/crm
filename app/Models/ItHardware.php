<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- ADD THIS LINE

class ItHardware extends Model
{
    use HasFactory;

    protected $table = 'it_hardwares';

    protected $fillable = [
        'issues',
        'description',
        'status',
        'remark',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // Assuming `user_id` is the foreign key
    }
    
}
