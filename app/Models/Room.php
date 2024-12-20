<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    public function boarders()
    {
        return $this->hasMany(Boarders::class);
    }
    public function getVacancyAttribute()
    {
        return $this->capacity - $this->boarders()->count();
    }
}
