<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    protected $guarded = [];

    protected $casts = [
        'bol_edit_data' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function carrier()
    {
        return $this->belongsTo(External::class, 'carrier_id');
    }

    // app/Models/Load.php
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class, 'load_equipment_type');
    }

    public function carrierVerification()
    {
        return $this->hasOne(\App\Models\CarrierVerification::class, 'load_id');
    }

}