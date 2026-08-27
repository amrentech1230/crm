<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming `user_id` is the foreign key
    }

    public function loads()
    {
        return $this->hasMany(Load::class);
    }

    
    public function state()
    {
        return $this->belongsTo(State::class, 'customer_state', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'customer_country', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
