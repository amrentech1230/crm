<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class External extends Model
{

    protected $fillable = [
    'carrier_name',
    'carrier_mc_ff',
    'carrier_mc_ff_input',
    'carrier_dot',
    'carrier_address_two',
    'carrier_country',
    'carrier_state',
    'carrier_city',
    'carrier_zip',
    'carrier_contact_name',
    'carrier_email',
    'carrier_telephone',
    'carrier_extn',
    'carrier_fax',
    'carrier_status',
    'carrier_payment_terms',
    'carrier_factoring_company',
    'carrier_notes',
	'mc_check',
    'carrier_file_upload',
	'carrier_block'	// if storing file path
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
