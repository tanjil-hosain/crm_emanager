<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Branch extends Model
{
    protected $fillable = [
        'branch_name',
        'branch_code',
        'phone',
        'address',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'branch_product')
            ->withPivot([
                'id',
                'purchase_price',
                'selling_price',
                'stock_quantity',
                'alert_quantity',
                'status',
            ])
            ->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}