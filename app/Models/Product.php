<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id','subcategory_id','name','sku', 'description','purchase_price','selling_price', 'stock_quantity', 'unit', 'image', 'status' ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

     public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }
}
