<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductView;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\WebsiteView;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name'     => 'cshop',
            'password' => 'cshop@2025',
        ]);

        Product::query()->insert(
            array_map(
                fn($num) => ['name' => "A$num", 'created_at' => now(), 'updated_at' => now()],
                range(1, 9)
            )
        );

        // 本地数据填充
        if(app()->environment('local')){
            ProductView::factory(100)->create();

            WebsiteView::factory(100)->create();
            Order::factory(100)->create();
        }
    }
}
