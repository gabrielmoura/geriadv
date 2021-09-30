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
 */
class Benefits extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable=['name','description','client_id'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
        //->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }
}
