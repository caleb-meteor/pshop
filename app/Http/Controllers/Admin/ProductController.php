<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * @author Caleb 2025/3/4
     */
    public function index()
    {
        return $this->success(
            ProductService::instance()->getProducts()
        );
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'price' => 'required|numeric',
        ]);

        return $this->success(
            ProductService::instance()->updateProduct($product, $request->all())
        );
    }
}
