<?php

namespace App\Filament\Widgets;

use App\Models\Boarders;
use App\Models\Invoice;
use App\Models\Room;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BoardersStatOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalCapacity = Room::query()->sum('capacity');
        $totalBoarders = Boarders::query()->count();
        $availableSpaces = max(0, $totalCapacity - $totalBoarders);

        return [
            Stat::make('Total Boarders', $totalBoarders),
            Stat::make('Total Rooms', Room::query()->count()),
            Stat::make('Total Room Capacity', $totalCapacity),
            Stat::make('Available Spaces', $availableSpaces)
        ];
    }
}
