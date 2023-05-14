<?php

namespace App\Http\Services;

use App\Http\Chain\DiscountBuyFiveGetOne;
use App\Http\Chain\DiscountCheapestForBuyTwo;
use App\Http\Chain\DiscountTenPercentOverThousand;
use App\Http\Contracts\IOrderService;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Requests\OrderStoreRequest;

class OrderService implements IOrderService
{
    private OrderRepository $orderRepository;
    private ProductRepository $productRepository;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function getAll() {
        return $this->orderRepository->getAll();
    }

    public function getByCondition(array $conditions) {
        return $this->orderRepository->getByCondition($conditions);
    }

    public function store(OrderStoreRequest $request) {
        $order = $this->orderRepository->store(['customer_id' => $request->input('customer_id')]);
        foreach($request->input('items') as $item) {
            $product = $this->productRepository->getByCondition(['id' => $item['product_id']]);
            //Add order items.
            $order->order_items()->create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'total' => $item['quantity'] * $product->price
            ]);

            // Decrease stock
            $this->productRepository->update($product->id, ['stock' => $product->stock - $item['quantity']]);
        }
        return $order;
    }

    public function delete(int $id) {
        return $this->orderRepository->delete($id);
    }

    public function checkStock(array $items){
        foreach($items as $item){
            $product = $this->productRepository->getByCondition(['id' => $item['product_id']]);
            if($product->stock < $item["quantity"]) {
                return false;
            }
        }
        return true;
    }

    public function calculateDiscount($order){
        $checkDiscountFirst = new DiscountTenPercentOverThousand();
        $checkDiscountSecond = new DiscountBuyFiveGetOne();
        $checkDiscountThird = new DiscountCheapestForBuyTwo();

        $checkDiscountFirst->then($checkDiscountSecond);
        $checkDiscountSecond->then($checkDiscountThird);

        return $checkDiscountFirst->applyDiscount($order, array());
    }
}