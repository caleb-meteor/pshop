<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
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

        return $this->success(
            ProductService::instance()->getProducts()->select('id', 'name', 'price', 'discount_price')
        );
    }

    public function viewNum(Product $product)
    {
        ProductService::instance()->viewNum($product, 1);
        return $this->success();
    }
}
