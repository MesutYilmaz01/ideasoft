<?php

namespace App\Http\Controllers;

use App\Http\Chain\Discount;
use App\Http\Chain\DiscountTenPercentOverThousand;
use App\Http\Chain\DiscountBuyFiveGetOne;
use App\Http\Chain\DiscountCheapestForBuyTwo;
use App\Http\Contracts\IOrderService;
use App\Http\Contracts\IProductService;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

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
        $isEnoughStock = $this->checkStock($request->input('items'));
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

    private function checkStock(array $items){
        foreach($items as $item){
            $product = $this->productService->getByCondition(['id' => $item['product_id']]);
            if($product->stock < $item["quantity"]) {
                return false;
            }
        }
        return true;
    }

    public function calculateDiscount(int $id)
    {
        $order = $this->orderService->getByCondition(['id' => $id]);
        if(!$order) {
            return response('Bu id ile kayıt bulunamadı...',400);
        }

        $checkDiscountFirst = new DiscountTenPercentOverThousand();
        $checkDiscountSecond = new DiscountBuyFiveGetOne();
        $checkDiscountThird = new DiscountCheapestForBuyTwo();

        $checkDiscountFirst->then($checkDiscountSecond);
        $checkDiscountSecond->then($checkDiscountThird);
        $checkDiscountFirst->applyDiscount($order, array());
        
        $result = [
            'orderId' => $id,
            'discounts' => $order->discount['discounts'] ?? null,
            'totalDiscount' => $order->discount['totalDiscount'] ?? 0,
            'discountedTotal' => $order->discount['subtotal'] ?? 0
        ];

        return response($result, 200);

    }
}
