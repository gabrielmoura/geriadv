<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Recommendation
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $user_id Usuário
 * @property string $name Nome
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereUserId($value)
 */
class Recommendation extends Model
{
    use HasFactory;

    protected $connection = 'tenant';
    protected $fillable = ['name'];

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
}
