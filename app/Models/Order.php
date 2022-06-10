<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $fk_pigeon_id
 * @property int $fk_user_id
 * @property int $distance km
 * @property string $price
 * @property string|null $should_deliver_at deadline
 * @property string|null $delivered_at
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pigeon|null $pigeon
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFkPigeonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFkUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShouldDeliverAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'fk_pigeon_id', 'updated_at', 'created_at'];

    protected static function boot()
    {
        parent::boot();

        self::created(function (self $model) {
            $pigeon = $model->pigeon;

            $pigeon->delivery_before_downtime -= 1;
            $pigeon->update();
        });
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'MYR ' . $value,
        );
    }

    protected function distance(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value . ' km',
        );
    }

    protected function shouldDeliverAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->toDateTimeString(),
        );
    }

    public function pigeon()
    {
        return $this->hasOne(Pigeon::class, 'id','fk_pigeon_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user_id');
    }

    public static function resetPigeonDowntime(Pigeon $pigeon)
    {
        Pigeon::resetDowntime($pigeon);
    }
}
