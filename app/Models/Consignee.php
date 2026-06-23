<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Consignee extends Model
{

    protected $fillable = [
        'user_id',
        'consignee_name',
        'consignee_address',
        'consignee_country',
        'consignee_state',
        'consignee_city',
        'consignee_zip',
        'consignee_contact_name',
        'consignee_contact_email',
        'consignee_telephone',
        'consignee_ext',
        'consignee_toll_free',
        'consignee_fax',
        'consignee_hours',
        'consignee_appointments',
        'consignee_major_intersections',
        'consignee_status',
        'consignee_shipping_notes',
        'consignee_internal_notes',
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
