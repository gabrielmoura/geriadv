<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Benefits
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereUpdatedAt($value)
 * @property int $client_id Cliente
 * @property int|null $user_id Funcionário
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereUserId($value)
 */
class Benefits extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['name', 'description', 'client_id','wage','wage_factor','wage_type'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
        //->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }
}
