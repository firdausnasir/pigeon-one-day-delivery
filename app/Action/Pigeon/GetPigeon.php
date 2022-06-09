<?php

namespace App\Action\Pigeon;

use App\Models\Order;
use App\Models\Pigeon;
use Illuminate\Database\Eloquent\Collection;

class GetPigeon
{
    public static function execute(float | int $speed_needed): ?Pigeon
    {
        // reset availability of pigeons first
        ResetPigeonDowntime::execute();

        return Pigeon::query()
            ->with('latestOrder')
            ->available()
            ->where('speed', '>=', $speed_needed)
            ->first();
    }
}
