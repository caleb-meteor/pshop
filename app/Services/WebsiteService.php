<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductView;
use App\Models\WebsiteView;
use Caleb\Practice\Service;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class WebsiteService extends Service
{
    public function viewNum(int $num = 1)
    {
        WebsiteView::query()->updateOrCreate([
            'ip'   => request()->ip(),
            'date' => date('Y-m-d')
        ], [
            'num' => DB::raw('num + ' . $num)
        ]);
    }

    public function statistic()
    {
        return WebsiteView::query()
            ->select(DB::raw('sum(num) as num, ip'))
            ->groupBy('ip')
            ->get()
            ->toArray();
    }

    public function statisticByDate(array $date)
    {
        $dateNum = WebsiteView::query()
            ->select('num', 'ip', 'date')
            ->whereBetween('date', $date)->get()->groupBy(fn($item) => $item->date->toDateString());

        dump($dateNum->toArray());

        return collect(CarbonPeriod::create(...$date))->map(function ($date) use ($dateNum) {
            return [
                'date' => $date->format('Y-m-d'),
                'num'  => $dateNum->get($date->format('Y-m-d'), collect())->select('num', 'ip')->toArray(),
            ];
        });
    }
}
