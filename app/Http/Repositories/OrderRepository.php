<?php

namespace App\Http\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function getAll() {
        return Order::with('order_items')->get();
    }

    public function getByCondition(array $conditions) {
        return Order::with('order_items')->where($conditions)->first();
    }

    public function store(array $parameters) {
        return Order::create($parameters);
    }

    public function delete(int $id) {
        return $this->getByCondition(['id' => $id])->delete();
    }
}