<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Caleb\Practice\Exceptions\PracticeAppException;
use Caleb\Practice\QueryFilter;
use Caleb\Practice\Service;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService extends Service
{
    public function orderList(QueryFilter $filter)
    {
        return Order::filter($filter)->orderByDesc('id')->paginate();
    }

    public function orders(QueryFilter $filter)
    {
        return Order::filter($filter)->withSum('products', 'quantity')->orderByDesc('id')->get();
    }

    public function previewOrder(array $data)
    {
        $products          = ProductService::instance()->getProductByIds(array_column($data['products'], 'product_id'));
        $productQuantities = array_column($data['products'], 'quantity', 'product_id');

        $products->transform(function (Product $item) use ($productQuantities) {
            $item->product_id     = $item->id;
            $item->discount_price = $item->price;
            $item->quantity       = $productQuantities[$item['id']] ?? 0;
            return $item;
        });

        /** @var Collection $products */
        list($products, $reduction, $discount) = ProductService::instance()->formatPrice($products);

        return [
            'total_amount' => sprintf('%0.2f', round($products->sum(fn($item) => $item->discount_price * $item->quantity) - $reduction, 2)),
            'reduction'    => $reduction,
            'products'     => $products,
            'discount'     => $discount,
        ];
    }

    /**
     * @param string $userId
     * @param array $data
     * @return Order|\Illuminate\Database\Eloquent\Model
     * @throws \Caleb\Practice\Exceptions\PracticeAppException
     * @author Caleb 2025/3/4
     */
    public function createOrder(string $customerId, array $data)
    {
        $bank = BankService::instance()->getRandomBank();

        if (!$bank) {
            $this->throwAppException('Configuration incomplete, unable to place order.');
        }

        $orderData = $this->previewOrder($data);

        $order = Order::query()->create(array_merge([
            'order_number' => date('Ymd') . substr(uniqid(), -5),
            'status'       => 'wait_payment',
            'customer_id'  => $customerId,
            'remark'       => $data['remark'] ?? '',
        ], $orderData));

        $order->products()->createMany($orderData['products']->toArray());

        $order->address()->create($data['address'] ?? []);

        $bank            = $bank->toArray();
        $bank['bank_id'] = $bank['id'];
        $order->bank()->create($bank);

        $order->loadMissing('products', 'address', 'bank');

        return $order;
    }

    /**
     * @param Order $order
     * @param array $voucher
     * @param string $remark
     * @return bool
     * @author Caleb 2025/3/4
     */
    public function uploadOrderVoucher(Order $order, array $voucher, string $remark)
    {
        return $order->update([
            'voucher' => $voucher,
            'status'  => 'wait_check',
            'remark'  => $remark
        ]);
    }

    /**
     * @param Order $order
     * @param array $data
     * @return bool
     * @throws PracticeAppException
     * @author Caleb 2025/3/4
     */
    public function checkOrder(Order $order, array $data)
    {
        // 待检测的订单才允许修改状态
        if ($order->status != 'wait_check') {
            $this->throwAppException('Invalid order status');
        }

        $staus         = $data['status'];
        $order->status = $staus;

        if ($staus === 'paid') {
            $order->delivery_status = 'wait_delivery';
            $order->payment_time    = now();
        }

        return $order->save();
    }

    /**
     * @param Order $order
     * @param array $data
     * @return bool
     * @author Caleb 2025/3/4
     */
    public function delivery(Order $order, array $data)
    {
        $deliveryStatus         = $data['delivery_status'];
        $order->delivery_status = $deliveryStatus;
        if ($deliveryStatus === 'delivered') {
            $order->delivery_time = now();
        }
        $order->delivery_remark = $data['delivery_remark'] ?? '';
        return $order->save();
    }

    public function show(Order $order)
    {
        $order->loadMissing('products', 'address', 'bank');

        return $order;
    }

    public function statistic(string $date = null)
    {
        $orderNum = Order::query()
            ->when($date, function ($query) use ($date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($date)->startOfDay()->toDateTimeString(),
                    Carbon::parse($date)->endOfDay()->toDateTimeString(),
                ]);
            })->count();

        $data = Order::query()
            ->select(DB::raw('sum(total_amount) as total_amount, count(*) as order_num'))
            ->when($date, function ($query) use ($date) {
                $query->whereBetween('payment_time', [
                    Carbon::parse($date)->startOfDay()->toDateTimeString(),
                    Carbon::parse($date)->endOfDay()->toDateTimeString(),
                ]);
            })
            ->whereNotNull('payment_time')->first();

        $waitData = Order::query()
            ->select(DB::raw('sum(total_amount) as total_amount, count(*) as order_num'))
            ->where('status', 'wait_check')
            ->when($date, function ($query) use ($date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($date)->startOfDay()->toDateTimeString(),
                    Carbon::parse($date)->endOfDay()->toDateTimeString(),
                ]);
            })->first();

        return [
            'order_num'               => $orderNum,                 // 订单总数
            'total_amount'            => $data->total_amount ?? 0,  // 已付款金额
            'payment_order_num'       => $data->order_num ?? 0,     // 已付款订单
            'wait_check_order_num'    => $waitData->order_num ?? 0, // 待核验订单
            'wait_check_order_amount' => $waitData->total_amount ?? 0,  // 待核验订单金额
        ];
    }

    public function statisticByDate(array $date)
    {
        $date = [
            Carbon::parse($date[0])->startOfDay()->toDateTimeString(),
            Carbon::parse($date[1])->endOfDay()->toDateTimeString(),
        ];

        $orderNum = Order::query()
            ->select(DB::raw('count(*) as order_num, DATE_FORMAT(created_at, "%Y-%m-%d") as date'))
            ->whereBetween('created_at', $date)
            ->groupBy('date')->get()->keyBy('date');

        $data = Order::query()
            ->select(DB::raw('sum(total_amount) as total_amount, count(*) as order_num, DATE_FORMAT(payment_time, "%Y-%m-%d") as date'))
            ->whereNotNull('payment_time')
            ->whereBetween('payment_time', $date)
            ->groupBy('date')->get()->keyBy('date');

        return collect(CarbonPeriod::create(...$date))->map(function ($date) use ($orderNum, $data) {
            return [
                'date'              => $date->format('Y-m-d'),
                'order_num'         => $orderNum[$date->format('Y-m-d')]->order_num ?? 0,
                'payment_order_num' => $data[$date->format('Y-m-d')]->order_num ?? 0,
                'total_amount'      => $data[$date->format('Y-m-d')]->total_amount ?? 0,
            ];
        });
    }
}

