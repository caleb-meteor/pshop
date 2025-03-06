<?php

namespace App\Models;

use Caleb\Practice\Standardization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $product_id 商品id
 * @property string|null $date 日期
 * @property int $view_num 浏览量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView filter(\Caleb\Practice\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView whereViewNum($value)
 * @property string|null $ip ip
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView whereIp($value)
 * @property int $num 浏览量
 * @method static \Database\Factories\ProductViewFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductView whereNum($value)
 * @mixin \Eloquent
 */
class ProductView extends Model
{
    use Standardization, HasFactory;

    protected $fillable = [
        'product_id',
        'date',
        'ip',
        'num',
    ];

    protected $casts = [
        'date' => 'date'
    ];

}
