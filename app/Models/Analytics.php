<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Tem por objetivo armazenar informações para compor estatisticas.
 *
 * Class Analytics
 *
 * @package App\Models
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $log_name Identificação do Log
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property string $total Total da Contagem
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics newQuery()
 * @method static \Illuminate\Database\Query\Builder|Analytics onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics query()
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics whereLogName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Analytics withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Analytics withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $analyticsTable_type
 * @property int|null $analyticsTable_id
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics whereAnalyticsTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytics whereAnalyticsTableType($value)
 */
class Analytics extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['log_name', 'total', 'subject'];

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
