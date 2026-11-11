<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['invoice_number', 'customer_id', 'created_by', 'total_amount', 'total_cost', 'discount', 'tax', 'status', 'payment_status','sold_at', 'notes'  ];

    public function sale_items(){
        return $this->hasMany(SaleItem::class);
    }

    public function customers(){
        return $this->belongsTo(Customer::class);
    }
}
