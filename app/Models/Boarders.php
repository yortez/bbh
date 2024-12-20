<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boarders extends Model
{
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
}
