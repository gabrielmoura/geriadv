<?php

namespace App\Models;

use App\Observers\ClientStatusObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class ClientStatus extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'note_id', 'status'];
    private $status = ['analysis', //Analise
        'rejected', //Indeferido
        'deferred', //Deferido
        'called_off', //Cancelado
        'cancellation', //Cancelamento
        'deceased' //Falecido
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

    public static function boot()
    {
        parent::boot();
        ClientStatus::observe(ClientStatusObserver::class);
    }
}
