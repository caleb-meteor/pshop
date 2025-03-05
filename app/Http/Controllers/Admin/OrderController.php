<?php

namespace App\Http\Controllers\Admin;

use App\Filters\OrderFilter;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(OrderFilter $filter)
    {
        return $this->success(
            OrderService::instance()->orderList($filter)
        );
    }

    public function show(Order $order)
    {
        return $this->success(
            OrderService::instance()->show($order)
        );
    }

    public function checkOrder(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:paid,canceled'
        ]);

        return $this->success(
            OrderService::instance()->checkOrder($order, $request->all())
        );
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     * @author Caleb 2025/3/4
     */
    public function delivery(Request $request, Order $order)
    {
        $request->validate([
            'delivery_status' => 'required|in:wait_delivery,delivered',
            'delivery_remark' => 'sometimes|string'
        ]);

        return $this->success(
            OrderService::instance()->delivery($order, $request->all())
        );
    }
}
