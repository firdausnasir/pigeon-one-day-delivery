<?php

namespace App\Action\Order;

use App\Action\Pigeon\CalculateSpeed;
use App\Action\Pigeon\GetPigeon;
use App\Exceptions\NoPigeonAvailableException;
use App\Exceptions\OrderNotPossibleException;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class SubmitOrder
{
    /**
     * @throws \Throwable
     */
    public static function execute(array $data): array
    {
        $distance = Arr::get($data, 'distance', 0);
        $deadline = Arr::get($data, 'deadline', now()->toDateTimeString());
        $deadline = Carbon::parse($deadline);

        $is_pigeon_available = CheckOrderPossible::execute($distance, $deadline);

        throw_if($is_pigeon_available === false, new OrderNotPossibleException());

        $speed  = CalculateSpeed::execute($distance, $deadline);
        $cost   = CalculateCost::execute($data);
        $pigeon = GetPigeon::execute($speed);

        throw_if($pigeon === null, new NoPigeonAvailableException());

        $order                    = new Order();
        $order->fk_pigeon_id      = $pigeon->id;
        $order->fk_user_id        = auth()->id();
        $order->distance          = $distance;
        $order->price             = $cost;
        $order->should_deliver_at = $deadline;
        $order->save();

        $order = $order->refresh();

        return [
            'order_id'          => $order->id,
            'pigeon_name'       => $order->pigeon->name,
            'distance'          => $order->distance,
            'price'             => $order->price,
            'status'            => $order->status,
            'should_deliver_at' => $order->should_deliver_at,
        ];
    }
}
