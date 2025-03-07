<?php

namespace App\Services;

use App\Models\Discount;
use Caleb\Practice\Service;

class DiscountService extends Service
{
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @author Caleb 2025/3/5
     */
    public function getDiscountList()
    {
        return Discount::query()
            ->orderByDesc('is_effect')
            ->orderByDesc('end_time')
            ->paginate();
    }

    public function createDiscount(array $data)
    {
        return Discount::query()->create($data);
    }

    public function updateDiscount(Discount $discount, $data)
    {
        return $discount->update($data);
    }

    public function deleteDiscount(Discount $discount)
    {
        return $discount->delete();
    }

    public function setDiscountEffect(Discount $discount, array $data)
    {
        Discount::query()->update(['is_effect' => 0]);

        $endTime  = $data['end_time'] ?? null;
        $isEffect = $data['is_effect'];

        return $discount->update(['is_effect' => $isEffect, 'end_time' => $endTime]);
    }

    public function getEffect()
    {
        return Discount::query()
            ->where('is_effect', 1)
            ->where(function ($query) {
                $query->where('end_time', '>', now())->orWhereNull('end_time');
            })
            ->first();
    }
}
