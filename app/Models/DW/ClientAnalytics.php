<?php

namespace App\Models\DW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DW\ClientAnalytics
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics query()
 * @mixin \Eloquent
 */
class ClientAnalytics extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('database.dw_default');
    }


    protected $fillable = [
        "deferred_count",
        "analysis_count",
        "requirement_count",
        "amount_count",
        "recommendations",
        "client_count",
        "new_entry",
        "calendar_count",
        "benefits",
        "company_id",
        "sex_count"
    ];
    protected $casts = [
        "recommendations" => 'collection',
        "benefits" => 'collection',
        "sex_count" => 'collection'
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
}
