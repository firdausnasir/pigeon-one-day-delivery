<?php

namespace App\Action\Order;

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

        $available_pigeons = CheckOrderPossible::execute($data);

        throw_if($available_pigeons->isEmpty(), new OrderNotPossibleException());

        $cost   = CalculateCost::execute($data);
        $pigeon = GetPigeon::execute($available_pigeons);

        throw_if($pigeon === null, new NoPigeonAvailableException());

        $order                    = new Order();
        $order->fk_pigeon_id      = $pigeon->id;
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
