<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductView;
use Caleb\Practice\Service;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService extends Service
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     * @author Caleb 2025/3/4
     */
    public function getProducts()
    {
        return Product::all(['*', DB::raw('price as discount_price')]);
    }

    /**
     * @param Product $product
     * @param array $data
     * @return bool
     * @author Caleb 2025/3/4
     */
    public function updateProduct(Product $product, array $data)
    {
        return $product->update($data);
    }

    /**
     * @param array $ids
     * @return \Illuminate\Database\Eloquent\Collection
     * @author Caleb 2025/3/4
     */
    public function getProductByIds(array $ids)
    {
        return Product::query()->whereIn('id', $ids)->get();
    }

    public function viewNum(Product $product, int $num)
    {
        $ip = request()->ip() ?: 'unknown';
        return $product->views()->updateOrCreate(
            [
                'date' => now()->format('Y-m-d'),
                'ip'   => $ip
            ],
            [
                'num' => DB::raw('num + ' . $num)
            ]
        );
    }

    public function statistic(string $date = null)
    {
        $productViews = ProductView::query()
            ->select(DB::raw('sum(num) as num, product_id'))
            ->when($date, fn($query) => $query->whereDate('date', $date))
            ->groupBy('product_id')->get()->keyBy('product_id');

        return Product::query()->pluck('id')->map(function ($id) use ($productViews) {
            return [
                'id'  => $id,
                'num' => (int)($productViews[$id]->num ?? 0)
            ];
        });

    }

    public function statisticByDate(array $date)
    {
        $productDateNum = ProductView::query()
            ->select(DB::raw('sum(num) as num, product_id, date'))
            ->groupBy('product_id', 'date')->get()
            ->keyBy(fn($item) => $item->product_id . '_' . $item->date->toDateString());

        $dateCollection = collect(CarbonPeriod::create(...$date));
        return Product::query()->pluck('id')->map(function ($id) use ($productDateNum, $dateCollection) {
            return [
                'id'       => $id,
                'date_num' => $dateCollection->map(function ($date) use ($productDateNum, $id) {
                    return [
                        'date' => $date->format('Y-m-d'),
                        'num'  => (int)($productDateNum[$id . '_' . $date->format('Y-m-d')]->num ?? 0)
                    ];
                })->toArray()
            ];
        });
    }

    public function formatPrice(Collection $products)
    {
        $discount = DiscountService::instance()->getEffect();
        if (!$discount) {
            return [$products, 0, null];
        }

        if ($discount->type === 'discount') {
            return [$products->transform(function (Product $item) use ($discount) {
                $item->discount_price = sprintf('%.2f', round($item->price * ($discount->setting[$discount->type] / 100), 2));
                return $item;
            }), 0, $discount];
        }

        if ($discount->type === 'full_reduction') {
            $totalAmount = $products->sum(fn($item) => $item->price * $item['quantity']);
            if ($totalAmount >= $discount->setting[$discount->type]['full']) {
                return [$products, $discount->setting[$discount->type]['reduction'], $discount];
            }
        }

        if ($discount->type === 'buy_get_free') {
            $quantity = $products->sum('quantity');
            $freeNum  = (int)($quantity / ($discount->setting[$discount->type]['buy'] + $discount->setting[$discount->type]['free'])) * $discount->setting[$discount->type]['free'];
            $products = $products->sortBy('price')->values();
            $extraProducts = collect();
            foreach ($products as $product) {
                if ($freeNum == 0) {
                    break;
                }

                $availableFree = min($freeNum, $product['quantity']);
                $freeNum -= $availableFree;

                if($availableFree == $product['quantity']){
                    $product['discount_price'] = 0;
                }else{
                    $product['quantity'] -= $availableFree;
                    $extraProducts->push((clone $product)->forceFill(['quantity' => $availableFree, 'discount_price' => 0]));
                }
            }

            return [$extraProducts->merge($products)->sortBy('id')->sortBy('price')->values(), 0, $discount];
        }

        return [$products, 0, $discount];
    }
}
