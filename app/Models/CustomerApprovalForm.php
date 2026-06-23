<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerApprovalForm extends Model
{
    use HasFactory;

    // Explicit table name
    protected $table = 'customer_approval_form';

    // Mass assignable fields
    protected $fillable = [
        'agent_email',
        'agent_name',
        'customer_email',
        'company_name',
        'address',
        'country',
        'state',
        'city',
        'zip_code',
        'dispatcher_first_name',
        'dispatcher_last_name',
        'phone_number',
        'status',
        'requested_credit_limit',
        'credit_doc_upload',
    ];

    // Optional: cast numeric fields
    protected $casts = [
        'requested_credit_limit' => 'decimal:2',
    ];
}
