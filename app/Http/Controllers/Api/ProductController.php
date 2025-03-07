<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\DiscountService;
use App\Services\ProductService;
use App\Services\WebsiteService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * @author Caleb 2025/3/4
     */
    public function index()
    {
        WebsiteService::instance()->viewNum();

        $products = ProductService::instance()->getProducts();
        $effect = DiscountService::instance()->getEffect();
        if($effect && $effect->type === 'discount'){
            $products->transform(function (Product $item) use ($effect) {
                $item->discount_price = sprintf('%.2f', round($item->price * ($effect->setting[$effect->type] / 100), 2));
                return $item;
            })->select('id', 'name', 'price', 'discount_price');
        }
        return $this->success($products);
    }

    public function viewNum(Product $product)
    {
        ProductService::instance()->viewNum($product, 1);
        return $this->success();
    }
}
