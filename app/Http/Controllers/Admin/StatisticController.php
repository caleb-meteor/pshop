<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\WebsiteService;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function getStatistic(Request $request)
    {
        $request->validate([
            'date' => 'sometimes|nullable|date_format:Y-m-d'
        ]);

        $date = $request->date ?: null;

        return $this->success([
            'order' => OrderService::instance()->statistic($date),
            'product' => ProductService::instance()->statistic($date),
            'website' => WebsiteService::instance()->statistic($date),
        ]);
    }
}
