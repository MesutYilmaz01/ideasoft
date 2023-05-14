<?

namespace App\Http\Chain;

use App\Http\Contracts\IProductService;
use App\Models\Order;

class DiscountCheapestForBuyTwo extends Discount
{
    private IProductService $productService;

    public function __construct()
    {
        $this->productService = app(IProductService::class);
    }

    public function applyDiscount(Order $order, $resultArray)
    {
        foreach($order->order_items as $item)
        {
            $product = $this->productService->getByCondition(['id' => $item->product_id]);
            if($product->category == 1 && $item->quantity >= 2) {
                $cheapest = $this->getCheapestProduct($order->order_items);
                $resultArray['discounts'][] = [
                    'discountReason' => 'BUY_2_GET_20_PERCENT',
                    'discountAmount' => ($cheapest->unit_price*20)/100,
                    'subtotal' => $resultArray['subtotal'] - ($cheapest->unit_price*20)/100
                ];
                $resultArray['totalDiscount'] += ($cheapest->unit_price*20)/100;
                $resultArray['subtotal'] = $resultArray['subtotal'] - (($cheapest->unit_price*20)/100);
                break;
            }
        }
        return $this->next($order, $resultArray);
    }

    private function getCheapestProduct($items) {
        $cheapest = $items[0];
        for($i=1; $i<count($items); $i++) {
            if($items[$i]->unit_price < $cheapest->unit_price) {
                $cheapest = $items[$i];
            }
        }
        return $cheapest;
    }
}