<?php

namespace App\Http\Contracts;

use App\Http\Requests\OrderStoreRequest;

interface IOrderService
{
    public function getAll();

    public function getById(int $id);

    public function store(OrderStoreRequest $request);

    public function delete(int $id);

    public function checkStock(array $items);

    public function calculateDiscount($order);
}