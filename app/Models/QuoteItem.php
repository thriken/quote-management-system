<?php

namespace App\Models;

class QuoteItem extends Model
{
    protected $table = 'quote_items';
    
    protected $fillable = [
        'quote_id',
        'product_id',
        'quantity',
        'unit_price',
        'discount_rate'
    ];
}