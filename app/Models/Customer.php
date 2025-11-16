<?php

namespace App\Models;

class Customer extends Model
{
    protected $table = 'customers';
    
    protected $fillable = [
        'code',
        'short_name',
        'full_name',
        'address',
        'phone',
        'company_name',
        'credit_code',
        'bank',
        'account_number',
        'level'
    ];
}