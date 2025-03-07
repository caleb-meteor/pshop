<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Services\DiscountService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * @author Caleb 2025/3/7
     */
    public function getEffect()
    {
        /** @var Discount $effect */
        $effect = DiscountService::instance()->getEffect();
        if ($effect) {
            if ($effect->end_time) {
                $effect->remaining_seconds         = (int)$effect->end_time->diffInSeconds(now(), true);
                $effect->current_timestamp = now()->timestamp;
                $effect->end_timestamp     = $effect->end_time->timestamp;
            } else {
                $effect->remaining_seconds = null;
            }
        }
        return $this->success($effect);
    }
}
