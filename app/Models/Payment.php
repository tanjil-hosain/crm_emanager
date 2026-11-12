<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'sale_id',
        'received_by',
        'amount',
        'payment_method',
        'transaction_id',
        'paid_at',
        'notes',
    ];

    public function sale(){
        return $this->belongsTo(Sale::class);
    }

    public function receiver(){
        return $this->belongsTo(User::class, 'received_by');
    }
}
