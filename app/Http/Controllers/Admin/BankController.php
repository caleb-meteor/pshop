<?php

namespace App\Http\Controllers\Admin;

use App\Filters\BankFilter;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Services\BankService;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BankFilter $filter)
    {
        return $this->success(
            BankService::instance()->bankList($filter)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'card_number' => 'required|string',
            'bank_name' => 'required|string',
        ]);

        return $this->success(
            BankService::instance()->createBank($request->all())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required|string',
            'card_number' => 'required|string',
            'bank_name' => 'required|string',
        ]);

        BankService::instance()->updateBank($bank, $request->all());

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        BankService::instance()->deleteBank($bank);
        return $this->success();
    }
}
