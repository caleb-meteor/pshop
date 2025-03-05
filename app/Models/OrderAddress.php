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
 * @property string $name 收货人
 * @property string $phone 手机号
 * @property string $address 地址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress filter(\Caleb\Practice\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress withoutTrashed()
 * @mixin \Eloquent
 */
class OrderAddress extends Model
{
    use Standardization, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'address',
    ];
}
