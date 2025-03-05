<?php

namespace App\Filters;

use Caleb\Practice\QueryFilter;

class OrderFilter extends QueryFilter
{
    public function customerId($customerId)
    {
        return $this->query->where('customer_id', $customerId);
    }
}
