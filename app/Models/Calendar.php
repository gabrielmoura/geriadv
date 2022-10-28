<?php

namespace App\Models;

use EndyJasmi\Cuid;
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
 * @property string|null $address Address
 * @property int|null $lawyer_id Advogado
 * @property-read \App\Models\Lawyer|null $lawyer
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereLawyerId($value)
 */
class Calendar extends Model
{
    use SoftDeletes;
    use HasFactory;


    /**
     *
     */
    const RECURRENCE_RADIO = [
        'none' => 'Nenhum',
        'daily' => 'Diária',
        'weekly' => 'Semanalmente',
        'monthly' => 'Mensal',
    ];
    /**
     * @var string[]
     */
    protected $dates = [
        'end_time',
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    /**
     * @var string[]
     */
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
        'company_id',
        'properties',
        'lawyer_id',
        'address'
    ];
    /**
     * @var string[]
     */
    protected $casts = [
        'properties' => 'collection',
    ];

    /**
     * @var string
     */
    protected string $format;

    /**
     * @param false $update
     * @param null $id
     * @return string[]
     */
    public static function rules($update = false, $id = null)
    {
        return [
            'name' => 'required',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendars()
    {
        return $this->hasMany(Calendar::class, 'calendar_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar()
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id')->withDefault();
    }




    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */


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

    /**
     * @return array
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
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->pid = Cuid::slug();
        });
    }
}
