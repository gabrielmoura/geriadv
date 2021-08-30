<?php

namespace App\Models;

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
 */
class ClientStatus extends Model
{
    use HasFactory;

    protected $fillable = ['client_id','note_id','status'];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id=null)
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
}
