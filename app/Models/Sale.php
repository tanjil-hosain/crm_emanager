<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['invoice_number', 'customer_id', 'created_by', 'total_amount', 'total_cost', 'discount', 'tax', 'status', 'payment_status', 'sold_at', 'notes'];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function returns()
    {
        return $this->hasMany(SalesReturn::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
