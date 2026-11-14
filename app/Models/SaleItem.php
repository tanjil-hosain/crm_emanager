<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    public $fillable = ['sale_id', 'product_id', 'quantity', 'unit_price', 'unit_cost', 'subtotal'];

    public function sales()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function returnItems()
    {
        return $this->hasMany(SalesReturnItem::class);
    }
}
