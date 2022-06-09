<?php

namespace App\Http\Controllers\Api;

use App\Action\Order\SubmitOrder;
use App\Exceptions\NoPigeonAvailableException;
use App\Exceptions\OrderNotPossibleException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitOrderRequest;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function submit(SubmitOrderRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        try {
            $order = SubmitOrder::execute($data);
        } catch (OrderNotPossibleException $e) {
            return response()->json([
                'message' => 'No pigeon is available to deliver before the deadline'
            ], Response::HTTP_NOT_FOUND);
        } catch (NoPigeonAvailableException $e) {
            return response()->json([
                'message' => 'No pigeon is available right now'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception | \Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'details' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Order created',
            'data'    => $order
        ], Response::HTTP_CREATED);
    }

    public function details(Order $order): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => 'Order found',
            'data'    => [
                'order_id'          => $order->id,
                'pigeon_name'       => $order->pigeon->name,
                'distance'          => $order->distance,
                'price'             => $order->price,
                'status'            => $order->status,
                'should_deliver_at' => $order->should_deliver_at,
            ]
        ], Response::HTTP_OK);
    }

    public function delivered(Order $order): \Illuminate\Http\JsonResponse
    {
        $order->delivered_at = now();
        $order->save();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
