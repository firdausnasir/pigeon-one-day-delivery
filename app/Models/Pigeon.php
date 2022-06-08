<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pigeon
 *
 * @property int $id
 * @property string $name
 * @property int $speed km/h
 * @property int $range km
 * @property int $cost $2/km
 * @property int $is_available
 * @property int $downtime The time it needs to rest between two deliveries (hr)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Pigeon available()
 * @method static \Database\Factories\PigeonFactory factory(...$parameters)
 * @method static Builder|Pigeon newModelQuery()
 * @method static Builder|Pigeon newQuery()
 * @method static Builder|Pigeon query()
 * @method static Builder|Pigeon whereCost($value)
 * @method static Builder|Pigeon whereCreatedAt($value)
 * @method static Builder|Pigeon whereDowntime($value)
 * @method static Builder|Pigeon whereId($value)
 * @method static Builder|Pigeon whereIsAvailable($value)
 * @method static Builder|Pigeon whereName($value)
 * @method static Builder|Pigeon whereRange($value)
 * @method static Builder|Pigeon whereSpeed($value)
 * @method static Builder|Pigeon whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pigeon extends Model
{
    use HasFactory;

    /**
     * Scope a query to only include available pigeons.
     *
     * @param  Builder  $query
     * @return void
     */
    public function scopeAvailable(Builder $query): void
    {
        $query->where('is_available', 1);
    }
}
