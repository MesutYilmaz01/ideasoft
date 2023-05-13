<?

namespace App\Http\Chain;

use App\Models\Order;

abstract class Discount
{
    private $nextDiscount;

    public function then($nextDiscount)
    {
        $this->nextDiscount = $nextDiscount;
    }

    abstract function applyDiscount(Order $order, $resultArray);

    protected function next(Order $order, $resultArray) {
        if(!$this->nextDiscount) return;
        $this->nextDiscount->applyDiscount($order, $resultArray);
    }
}
