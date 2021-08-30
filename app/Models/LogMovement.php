<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LogMovement
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id Usuários
 * @property string $body
 * @method static \Illuminate\Database\Eloquent\Builder|LogMovement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogMovement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogMovement query()
 * @method static \Illuminate\Database\Eloquent\Builder|LogMovement whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogMovement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogMovement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogMovement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogMovement whereUserId($value)
 * @mixin \Eloquent
 */
class LogMovement extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','body'];

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
