<?php

namespace App\Action\Pigeon;

use App\Models\Order;
use App\Models\Pigeon;

class ResetPigeonDowntime
{
    public static function execute(): void
    {
        Pigeon::query()
            ->with('latestOrder')
            ->where('is_available', false)
            ->get()
            ->each(function (Pigeon $pigeon) {
                /* @var Order $latestOrder */
                $latestOrder = $pigeon->latestOrder;

                if (empty($latestOrder)) return;

                if (now()->floatDiffInHours($latestOrder->created_at) >= $pigeon->downtime) {
                    $pigeon->delivery_before_downtime = $pigeon->downtime;
                    $pigeon->is_available             = 1;
                    $pigeon->save();
                }
            });
    }
}
