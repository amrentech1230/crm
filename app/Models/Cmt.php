<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cmt extends Model
{
    use HasFactory;

    protected $table = 'cmts';

    protected $fillable = [
        'agent_name',
        'agent_email',
        'agent_ext',
        'pickup_city',
        'pickup_state',
        'pickup_zip_code',
        'pickup_date',
        'delivery_city',
        'delivery_state',
        'delivery_zip_code',
        'delivery_date',
        'equipment',
        'load_type',
        'commodity',
        'weight',
        'special_instructions',
        'rate'
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'delivery_date' => 'date',
        'rate' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
