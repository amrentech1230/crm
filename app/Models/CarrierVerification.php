<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrierVerification extends Model
{
    use HasFactory;

    protected $table = 'carrier_verification'; // correct declaration

    protected $fillable = [
        'load_id',
        'user_id',
        'bank_information',
        'factoring',
        'verification_factoring',
        'verification_status',
        'verification_carrier_phone_number',
        'verification_carrier_email',
        'verification_remark',
        'carrier_bank_docs',
        'follow_up_note',
    ];

    public function carrierVerification()
    {
        return $this->hasOne(\App\Models\CarrierVerification::class, 'load_id');
    }

    // public function loadData()
    // {
    //     return $this->belongsTo(Load::class, 'load_id', 'id');
    // }

}
