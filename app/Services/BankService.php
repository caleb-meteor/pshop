<?php

namespace App\Services;

use App\Models\Bank;
use Caleb\Practice\QueryFilter;
use Caleb\Practice\Service;

class BankService extends Service
{
    public function bankList(QueryFilter $filter)
    {
        return Bank::filter($filter)->orderByDesc('id')->paginate();
    }

    public function createBank(array $data)
    {
        $this->checkCardNumber($data['card_number']);

        return Bank::query()->create($data);
    }

    public function updateBank(Bank $bank, $data)
    {
        $this->checkCardNumber($data['card_number'], $bank->id);

        return $bank->update($data);
    }

    public function deleteBank(Bank $bank)
    {
        return $bank->delete();
    }

    /**
     * @return Bank|null
     * @author Caleb 2025/3/4
     */
    public function getRandomBank(): Bank|null
    {
        return Bank::query()->inRandomOrder()->first();
    }

    public function checkCardNumber(string $cardNumber, int $id = 0)
    {
        // 检测卡号是否重复
        $bank = Bank::query()->where('card_number', $cardNumber)
            ->when($id, function ($query, $id) {
                $query->where('id', '<>', $id);
            })->exists();

        if ($bank) {
            $this->throwAppException('Duplicate card number.');
        }
    }
}
