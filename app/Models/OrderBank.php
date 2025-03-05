<?php

namespace App\Models;

use Caleb\Practice\Standardization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $bank_id 银行id
 * @property string $name 银行卡持有人
 * @property string $card_number 银行卡号
 * @property string $bank_name 银行名称
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank filter(\Caleb\Practice\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderBank withoutTrashed()
 * @mixin \Eloquent
 */
class OrderBank extends Model
{
    use Standardization, SoftDeletes;

    protected $fillable = [
        'order_id',
        'bank_id',
        'name',
        'card_number',
        'bank_name',
    ];
}
