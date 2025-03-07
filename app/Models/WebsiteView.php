<?php

namespace App\Models;

use Caleb\Practice\Standardization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

/**
 *
 *
 * @property int $id
 * @property string|null $date
 * @property string|null $ip
 * @property int $num
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebsiteView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebsiteView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebsiteView query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebsiteView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebsiteView whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebsiteView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebsiteView whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebsiteView whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebsiteView whereUpdatedAt($value)
 * @method static \Database\Factories\WebsiteViewFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebsiteView filter(\Caleb\Practice\QueryFilter $filter)
 * @mixin \Eloquent
 */
class WebsiteView extends Model
{
    use Standardization, HasFactory;

    protected $fillable = [
        'date',
        'ip',
        'num',
    ];

    protected $casts = [
        'date' => 'date',
        'num' => 'integer',
    ];
}
