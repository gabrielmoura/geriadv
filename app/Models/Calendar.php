<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    protected $connection = 'tenant';
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
        'description'
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
