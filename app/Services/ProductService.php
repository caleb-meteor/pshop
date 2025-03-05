<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductView;
use Caleb\Practice\Service;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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

    public function statistic()
    {
        $productViews = ProductView::query()->select(DB::raw('sum(num) as num, product_id'))->groupBy('product_id')->get()->keyBy('product_id');
        return Product::query()->pluck('id')->map(function ($id) use ($productViews) {
            return [
                'id'  => $id,
                'num' => (int) ($productViews[$id]->num ?? 0)
            ];
        });

    }

    public function statisticByDate(array $date)
    {
        $productDateNum       = ProductView::query()
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
                        'num'  => (int) ($productDateNum[$id . '_' . $date->format('Y-m-d')]->num ?? 0)
                    ];
                })->toArray()
            ];
        });
    }
}
