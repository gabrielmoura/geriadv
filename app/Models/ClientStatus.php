<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\ClientStatus
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $client_id Cliente
 * @property int|null $note_id Observações
 * @property string $status Status do Cliente
 * @method static \Illuminate\Database\Eloquent\Builder|ClientStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientStatus whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientStatus whereNoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $user_id Funcionário
 * @method static \Illuminate\Database\Eloquent\Builder|ClientStatus whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 */
class ClientStatus extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $connection = 'tenant';
    protected $fillable = ['client_id', 'note_id', 'status'];
    private $status = ['analysis', //Analise
        'rejected', //Indeferido
        'deferred', //Deferido
        'called_off', //Cancelado
        'cancellation', //Cancelamento
        'deceased', //Falecido
        'requirement' //Exigência
    ];


    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id = null)
    {
        return [
            'name' => 'required',
        ];
    }

    /*
    |------------------------------------------------------------------------------------
    | Relations
    |------------------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();

    }
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

    public function client()
    {

        $this->belongsTo(Clients::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
        //->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }
}
