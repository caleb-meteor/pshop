<?php

namespace App\Filters;

use Caleb\Practice\QueryFilter;

class BankFilter extends QueryFilter
{
    public function cardNumber($cardNumber)
    {
        return $this->query->where('card_number', 'like', "%$cardNumber%");
    }
}
