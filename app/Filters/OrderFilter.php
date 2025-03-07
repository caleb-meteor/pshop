<?php

namespace App\Filters;

use Caleb\Practice\QueryFilter;

class OrderFilter extends QueryFilter
{
    public function customerId($customerId)
    {
        return $this->query->where('customer_id', $customerId);
    }

    public function orderNumber($orderNumber)
    {
        return $this->query->whereLike('order_number', '%'.$orderNumber.'%');
    }

    public function status($status)
    {
        return $this->query->where('status', $status);
    }

    public function deliveryStatus($deliveryStatus)
    {
        return $this->query->where('delivery_status', $deliveryStatus);
    }
}
