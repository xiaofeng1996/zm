<?php

namespace Repositories\Web\Order;

use Repositories\Base\Order\OrderCreateBaseRepository;
use Entities\Order;

class OrderCreateRepository extends OrderCreateBaseRepository
{
    public function getOrderById($order_id)
    {
        $order = Order::with('merchant', 'goods')->find($order_id);
        return $order;
    }

}