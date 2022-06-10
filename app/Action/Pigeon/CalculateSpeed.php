<?php

namespace App\Action\Pigeon;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class CalculateSpeed
{
    public static function execute(float | int $distance, CarbonInterface $deadline): float | int
    {
        // distance = speed / time
        // we have distance and time, so we can find speed it takes to finish the delivery
        // speed (km/h) = distance (km) / time (h)
        $deadline          = Carbon::parse($deadline);
        $deadline_in_hours = $deadline->floatDiffInHours(now());

        return $distance / $deadline_in_hours;
    }
}
