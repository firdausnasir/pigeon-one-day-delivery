<?php

namespace App\Action\Order;

use Illuminate\Support\Arr;

class CalculateCost
{
    private const COST = 2;

    public static function execute(array $data): float | int
    {
        $distance = Arr::get($data, 'distance', 0);

        return self::COST * $distance;
    }
}
