<?php

namespace App\Console\Commands;

use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\WebsiteService;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // dump(WebsiteService::instance()->statistic());
        // dump(WebsiteService::instance()->statisticByDate(['2025-02-28', '2025-03-05']));
        // dd(1);
        // dd(2);
        // dump(ProductService::instance()->statistic());
        // dump(ProductService::instance()->statisticByDate(['2025-02-28', '2025-03-05']));
        // dd(1);
        // dump(OrderService::instance()->statistic());
        // dd(OrderService::instance()->statisticByDate(['2025-02-28', '2025-03-05']));
    }
}
