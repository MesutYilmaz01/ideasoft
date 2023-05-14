<?php

namespace App\Http\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function getAll() {
        return Order::with('order_items')->get();
    }

    public function getById(int $id) {
        return Order::with('order_items')->where('id', $id)->first();
    }

    public function store(array $parameters) {
        return Order::create($parameters);
    }

    public function delete(int $id) {
        return $this->getById($id)->delete();
    }
}