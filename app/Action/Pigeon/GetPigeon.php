<?php

namespace App\Action\Pigeon;

use App\Models\Order;
use App\Models\Pigeon;
use Illuminate\Database\Eloquent\Collection;

class GetPigeon
{
    public static function execute(Collection $pigeons): ?Pigeon
    {
        return $pigeons
            ->fresh('latestOrder')
            ->each(function (Pigeon $pigeon) {
                /* @var Order $latestOrder */
                $latestOrder = $pigeon->latestOrder->first();

                if (empty($latestOrder)) return;

                if (now()->floatDiffInHours($latestOrder->created_at) >= $pigeon->downtime) {
                    $pigeon->delivery_before_downtime = $pigeon->downtime;
                    $pigeon->is_available             = true;
                    $pigeon->save();
                }
            })
            ->fresh('latestOrder')
            ->filter(fn(Pigeon $pigeon) => $pigeon->is_available == 1)
            ->sortBy(fn(Pigeon $pigeon) => $pigeon->range)
            ->first();
    }
}
