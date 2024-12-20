<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function boarders()
    {
        return $this->belongsTo(Boarders::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
