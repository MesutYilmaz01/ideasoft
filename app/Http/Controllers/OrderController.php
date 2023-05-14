<?php

namespace App\Http\Controllers;

use App\Http\Contracts\IOrderService;
use App\Http\Contracts\IProductService;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    private IOrderService $orderService;
    private IProductService $productService;

    public function __construct(IOrderService $orderService, IProductService $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }

    public function getAll(){
        return OrderResource::collection($this->orderService->getAll());
    }
    
    public function get(int $id){
        $order = $this->orderService->getByCondition(['id' => $id]);
        if(!$order) {
            return response('Bu id ile kayıt bulunamadı...',400);
        }
        return new OrderResource($order);
    }

    public function store(OrderStoreRequest $request)
    {
        //Check Stock
        $isEnoughStock = $this->orderService->checkStock($request->input('items'));
        if(!$isEnoughStock) {
            return response('Ürünlerinizden bazıları stokta yok...',400);
        }
        $order = $this->orderService->store($request);
        if(!$order) {
            return response('Ekleme işlemi başarısız...',400);
        }
        return new OrderResource($order);
    }

    public function delete(int $id)
    {
        $order = $this->orderService->getByCondition(['id' => $id]);
        if(!$order) {
            return response('Bu id ile kayıt bulunamadı...',400);
        }
        $isDeleted = $this->orderService->delete($id);
        if(!$isDeleted) {
            return response('Silme işlemi başarısız...',400);
        }
        return response('Silme başarılı',200);
    }

    public function calculateDiscount(int $id)
    {
        $order = $this->orderService->getByCondition(['id' => $id]);
        if(!$order) {
            return response('Bu id ile kayıt bulunamadı...',400);
        }
        
        $resultArray = $this->orderService->calculateDiscount($order);
        
        $result = [
            'orderId' => $id,
            'discounts' => $resultArray['discounts'] ?? [],
            'totalDiscount' => $resultArray['totalDiscount'] ?? 0,
            'discountedTotal' => $resultArray['subtotal'] ?? 0
        ];

        return response($result, 200);
    }
}
