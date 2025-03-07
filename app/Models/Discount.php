<?php

namespace App\Models;

use Caleb\Practice\Standardization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $type 类型
 * @property string $title 标题
 * @property string|null $description 描述
 * @property array|null $setting 设置
 * @property int $is_effect 是否生效
 * @property Carbon|null $end_time 结束时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereIsEffect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount filter(\Caleb\Practice\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount withoutTrashed()
 * @mixin \Eloquent
 */
class Discount extends Model
{
    use Standardization, SoftDeletes;

    protected $fillable = [
        'type',
        'title',
        'description',
        'setting',
        'is_effect',
        'end_time',
    ];

    protected $casts = [
        'setting' => 'json',
        'end_time' => 'datetime'
    ];
}
