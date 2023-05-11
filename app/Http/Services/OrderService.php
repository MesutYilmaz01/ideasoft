<?php

namespace App\Http\Services;

use App\Http\Contracts\IOrderService;
use App\Http\Repositories\OrderRepository;

class OrderService implements IOrderService
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
}