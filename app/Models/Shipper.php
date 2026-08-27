<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Shipper extends Model
{

    protected $fillable = [
        'user_id',
        'shipper_name',
        'shipper_address',
        'shipper_country',
        'shipper_state',
        'shipper_city',
        'shipper_zip',
        'shipper_contact_name',
        'shipper_contact_email',
        'shipper_telephone',
        'shipper_extn',
        'shipper_toll_free',
        'shipper_fax',
        'shipper_hours',
        'shipper_appointments',
        'shipper_major_intersections',
        'shipper_status',
        'shipper_shipping_notes',
        'shipper_internal_notes',
        'commenter_name',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

public function teamleader()
{
    return $this->belongsTo(TeamLeader::class, 'team_lead');
}

public function managers()
{
    return $this->belongsTo(Manger::class, 'manager'); 
}
}
