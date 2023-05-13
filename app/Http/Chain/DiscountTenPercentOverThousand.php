<?

namespace App\Http\Chain;

use App\Models\Order;

class DiscountTenPercentOverThousand extends Discount
{
    public function applyDiscount(Order $order, $resultArray)
    {
        $orderTotal = 0;
        $resultArray['totalDiscount'] = 0;

        foreach($order->order_items as $item){
            $orderTotal+= $item->total;
        }
        $resultArray['subtotal'] = $orderTotal;

        if($resultArray['subtotal'] >= 1000) {
            $resultArray['discounts'][] = [
                'discountReason' => '10_PERCENT_OVER_1000',
                'discountAmount' => $resultArray['subtotal']*10/100,
                'subtotal' => $resultArray['subtotal'] - (($resultArray['subtotal']*10)/100)
            ];
            $resultArray['totalDiscount'] = $resultArray['subtotal']*10/100;
            $resultArray['subtotal'] = $resultArray['subtotal'] - (($resultArray['subtotal']*10)/100);
            $order->discount = $resultArray;
        }
        return $this->next($order, $resultArray);
    }
}