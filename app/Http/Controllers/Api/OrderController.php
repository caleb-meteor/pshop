<?php

namespace App\Http\Controllers\Api;

use App\Filters\OrderFilter;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Caleb\Practice\ThrowException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ThrowException;

    public function index(Request $request, OrderFilter $filter)
    {
        $request->validate([
            'customer_id' => 'required',
        ]);

        return $this->success(
            OrderService::instance()->orders($filter)
        );
    }

    public function previewOrder(Request $request)
    {
        $data = $request->validate([
            'customer_id'           => 'required',
            'products'              => 'required|array',
            'products.*.product_id' => 'required|integer',
            'products.*.quantity'   => 'required|integer|min:1',
        ]);

        return $this->success(
            OrderService::instance()->previewOrder($data)
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Caleb\Practice\Exceptions\PracticeAppException
     * @author Caleb 2025/3/4
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'           => 'required',
            'products'              => 'required|array',
            'products.*.product_id' => 'required|integer',
            'products.*.quantity'   => 'required|integer|min:1',
            'address'               => 'required|array',
            'address.name'          => 'sometimes|string',
            'address.phone'         => 'sometimes|string',
            'address.address'       => 'sometimes|string',
            'remark'                => 'sometimes|string'
        ]);

        return $this->success(
            OrderService::instance()->createOrder($data['customer_id'], $data)
        );
    }

    public function show(Request $request, Order $order)
    {
        $request->validate([
            'customer_id' => 'required',
        ]);
        return $this->success(
            OrderService::instance()->show($order)
        );
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     * @throws \Caleb\Practice\Exceptions\PracticeAppException
     * @author Caleb 2025/3/4
     */
    public function uploadOrderVoucher(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_id' => 'required',
            'voucher'     => 'required|array',
            'remark'      => 'sometimes|string|max:255'
        ]);

        if ($order->customer_id !== $data['customer_id']) {
            $this->throwAppException('Invalid user');
        }

        OrderService::instance()->uploadOrderVoucher($order, $data['voucher'], $data['remark'] ?? '');

        return $this->success();
    }
}
