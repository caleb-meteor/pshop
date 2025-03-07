<?php

namespace App\Models;

use Caleb\Practice\Standardization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property string $user_id 用户id
 * @property string $total_amount 总金额
 * @property string $status 状态
 * @property string $delivery_status 发货状态
 * @property string|null $voucher 支付凭证
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order filter(\Caleb\Practice\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeliveryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereVoucher($value)
 * @property string $order_number 订单号
 * @property-read \App\Models\OrderAddress|null $address
 * @property-read \App\Models\OrderBank|null $bank
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderProduct> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderNumber($value)
 * @property string|null $payment_time 支付时间
 * @property string $delivery_remark 发货备注
 * @property string $remark 订单备注
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeliveryRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereRemark($value)
 * @property string $customer_id 用户id
 * @property string|null $delivery_time 发货时间
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeliveryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order withoutTrashed()
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @property string $reduction 满减金额
 * @property array<array-key, mixed>|null $discount 优惠信息
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereReduction($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use Standardization, SoftDeletes, HasFactory;

    protected $fillable = [
        'customer_id',
        'order_number',
        'total_amount',
        'status',
        'delivery_status',
        'voucher',
        'payment_time',
        'delivery_remark',
        'remark',
        'created_at',
        'discount',
        'reduction',
    ];

    protected $casts = [
        'total_amount' => 'float',
        'voucher' => 'array',
        'discount' => 'json'
    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function address()
    {
        return $this->hasOne(OrderAddress::class);
    }

    public function bank()
    {
        return $this->hasOne(OrderBank::class);
    }
}
