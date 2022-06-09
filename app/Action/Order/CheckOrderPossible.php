<?php

namespace App\Action\Order;

use App\Models\Pigeon;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class CheckOrderPossible
{
    public static function execute(array $data): Collection
    {
        $distance = Arr::get($data, 'distance', 0);
        $deadline = Arr::get($data, 'deadline', now()->toDateTimeString());
        $deadline = Carbon::parse($deadline);

        // distance = speed / time
        // we have distance and time, so we can find speed it takes to finish the delivery
        // speed (km/h) = distance (km) / time (h)
        $deadline_in_hours = $deadline->floatDiffInHours(now());
        $speed_needed      = $distance / $deadline_in_hours;

        return Pigeon::query()->available()->where('speed', '>=', $speed_needed)->get();
    }
}
