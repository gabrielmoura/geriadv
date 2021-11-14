<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Calendar
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $idEx ID externo
 * @property string $name Titulo
 * @property \Illuminate\Support\Carbon $start_time Inicio
 * @property \Illuminate\Support\Carbon $end_time Fim
 * @property string $recurrence
 * @property int|null $company_id Empresa
 * @property int|null $calendar_id
 * @property \Illuminate\Support\Collection|null $properties
 * @property string|null $description Descrição
 * @property-read Calendar|null $calendar
 * @property-read \Illuminate\Database\Eloquent\Collection|Calendar[] $calendars
 * @property-read int|null $calendars_count
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar newQuery()
 * @method static \Illuminate\Database\Query\Builder|Calendar onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar query()
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereCalendarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereIdEx($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereRecurrence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Calendar withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Calendar withoutTrashed()
 * @mixin \Eloquent
 */
class Calendar extends Model
{
    use SoftDeletes;
    use HasFactory;


    const RECURRENCE_RADIO = [
        'none' => 'None',
        'daily' => 'Daily',
        'weekly' => 'Weekly',
        'monthly' => 'Monthly',
    ];
    protected $dates = [
        'end_time',
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'name',
        'end_time',
        'event_id',
        'start_time',
        'recurrence',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'company_id'
    ];
    protected $casts = [
        'properties' => 'collection',
    ];
    protected string $format;

    public static function rules($update = false, $id = null)
    {
        return [
            'name' => 'required',
        ];
    }

    public function calendars()
    {
        return $this->hasMany(Calendar::class, 'calendar_id', 'id');
    }

    public function calendar()
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }

    public function getStartTimeAttribute($value)
    {
        //Carbon::parse()
        return $value ? Carbon::parse($value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;

    }


    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */

    public function getEndTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    /*
    |------------------------------------------------------------------------------------
    | Relations
    |------------------------------------------------------------------------------------
    */

    /*
    |------------------------------------------------------------------------------------
    | Scopes
    |------------------------------------------------------------------------------------
    */

    /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */

    public function getEventOptions()
    {
        return [
            'color' => $this->background_color,
            //etc
        ];
    }
    /*
        public function saveQuietly()
        {
            return static::withoutEvents(function () {
                return $this->save();
            });
        } */
}
