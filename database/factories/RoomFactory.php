<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        static $number = 1;

        return [
            'number' => 'Room ' . $number++,
            'capacity' => 4,
            'rate' => 1000.00,
        ];
    }
}
