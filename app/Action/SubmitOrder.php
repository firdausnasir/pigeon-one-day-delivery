<?php

namespace App\Action;

use App\Exceptions\OrderNotPossibleException;

class SubmitOrder
{
    /**
     * @throws \Throwable
     */
    public static function execute(array $data)
    {
        $available_pigeons = CheckOrderPossible::execute($data);

        throw_if($available_pigeons->isEmpty(), new OrderNotPossibleException());

        return collect();
    }
}
