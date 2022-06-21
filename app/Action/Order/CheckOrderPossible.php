<?php

namespace App\Action\Order;

use App\Action\Pigeon\CalculateSpeed;
use App\Models\Pigeon;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class CheckOrderPossible
{
    public static function execute(float | int $distance, CarbonInterface $deadline): bool
    {
        $speed_needed = CalculateSpeed::execute($distance, $deadline);

        return Pigeon::query()
            ->available()
            ->speedRange($distance, $speed_needed)
            ->exists();
    }
}
