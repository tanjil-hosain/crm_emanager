<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['name', 'email', 'phone','company_name', 'source', 'status', 'assigned_to', 'notes' ];

    public function assignedUser(){
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
