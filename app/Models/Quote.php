<?php

namespace App\Models;

class Quote extends Model
{
    protected $table = 'quotes';
    
    protected $fillable = [
        'customer_id',
        'category',
        'version',
        'is_active',
        'discount_rate',
        'rebate_rate',
        'effective_date',
        'expiry_date'
    ];
}