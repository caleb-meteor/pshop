<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Services\DiscountService;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(
            DiscountService::instance()->getDiscountList()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type'                             => 'sometimes|required|in:discount,full_reduction,buy_get_free',
            'title'                            => 'sometimes|string',
            'description'                      => 'sometimes|string',
            'setting'                          => 'sometimes|array',
            'setting.discount'                 => 'required_if:type,discount|numeric|min:0|max:100',
            'setting.full_reduction'           => 'required_if:type,full_reduction|array',
            'setting.full_reduction.full'      => 'required_if:type,full_reduction|numeric|min:0',
            'setting.full_reduction.reduction' => 'required_if:type,full_reduction|numeric|min:0',
            'setting.buy_get_free'             => 'required_if:type,buy_get_free|array',
            'setting.buy_get_free.buy'         => 'required_if:type,buy_get_free|numeric|min:1',
            'setting.buy_get_free.free'        => 'required_if:type,buy_get_free|numeric|min:1',
        ]);

        return $this->success(
            DiscountService::instance()->createDiscount($data)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $data = $request->validate([
            'type'                             => 'sometimes|required|in:discount,full_reduction,buy_get_free',
            'title'                            => 'sometimes|string',
            'description'                      => 'sometimes|string',
            'setting'                          => 'sometimes|array',
            'setting.discount'                 => 'required_if:type,discount|numeric|min:0|max:100',
            'setting.full_reduction'           => 'required_if:type,full_reduction|array',
            'setting.full_reduction.full'      => 'required_if:type,full_reduction|numeric|min:0',
            'setting.full_reduction.reduction' => 'required_if:type,full_reduction|numeric|min:0',
            'setting.buy_get_free'             => 'required_if:type,buy_get_free|array',
            'setting.buy_get_free.buy'         => 'required_if:type,buy_get_free|numeric|min:1',
            'setting.buy_get_free.free'        => 'required_if:type,buy_get_free|numeric|min:1',
        ]);

        DiscountService::instance()->updateDiscount($discount, $data);

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        DiscountService::instance()->deleteDiscount($discount);

        return $this->success();
    }

    /**
     * @param Request $request
     * @param Discount $discount
     * @return \Illuminate\Http\JsonResponse
     * @author Caleb 2025/3/5
     */
    public function setEffect(Request $request, Discount $discount)
    {
        $data = $request->validate([
            'is_effect' => 'required|boolean',
            'end_time' => 'nullable|date:format,Y-m-d H:i:s',
        ]);
        DiscountService::instance()->setDiscountEffect($discount, $data);
        return $this->success();
    }
}
