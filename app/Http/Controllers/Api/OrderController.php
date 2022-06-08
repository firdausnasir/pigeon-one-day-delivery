<?php

namespace App\Http\Controllers\Api;

use App\Action\CheckOrderPossible;
use App\Action\SubmitOrder;
use App\Exceptions\OrderNotPossibleException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitOrderRequest;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function submit(SubmitOrderRequest $request)
    {
        $data = $request->validated();

        try {
            $order = SubmitOrder::execute($data);
        } catch (OrderNotPossibleException $e) {
            return response()->json([
                'message' => 'No pigeon is available to deliver before the deadline'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception|\Throwable $e) {
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
}
