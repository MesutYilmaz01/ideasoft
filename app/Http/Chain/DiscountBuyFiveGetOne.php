<?

namespace App\Http\Chain;

use App\Http\Contracts\IProductService;
use App\Models\Order;

class DiscountBuyFiveGetOne extends Discount
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
            if($product->category == 2 && $item->quantity >= 6) {
                $resultArray['discounts'][] = [
                    'discountReason' => 'BUY_5_GET_1',
                    'discountAmount' => $product->price,
                    'subtotal' => $resultArray['subtotal'] - $product->price
                ];
                $resultArray['totalDiscount'] += $product->price;
                $resultArray['subtotal'] = $resultArray['subtotal'] - $product->price;
                $order->discount = $resultArray;
                break;
            }
        }
        return $this->next($order, $resultArray);
    }
}