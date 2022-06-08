<?php

namespace App\Http\Controllers\Api;

use App\Action\CheckCapablePigeon;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitOrderRequest;

class OrderController extends Controller
{
    public function submit(SubmitOrderRequest $request)
    {
        $data = $request->validated();

        $capable_pigeon = CheckCapablePigeon::execute($data);

        if ($capable_pigeon->isEmpty()) {
            return response()->json([
                'message' => 'No pigeon is available to deliver before the deadline'
            ], 404);
        }


    }
}
