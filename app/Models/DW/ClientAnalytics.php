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
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deferred_count
 * @property int|null $analysis_count
 * @property int|null $requirement_count
 * @property int|null $amount_count
 * @property int|null $client_count
 * @property int|null $new_entry
 * @property int|null $calendar_count
 * @property int|null $invoice_count
 * @property int|null $pendency_count
 * @property int|null $schedules_count
 * @property mixed|null $age_count
 * @property \Illuminate\Support\Collection|null $sex_count
 * @property \Illuminate\Support\Collection|null $recommendations Quantidade de Processos por Recomendações
 * @property \Illuminate\Support\Collection|null $benefits Quantidade de Processos por Beneficios
 * @property mixed|null $lawyer Quantidade por Advogados
 * @property mixed|null $employee Quantidade por Funcionários
 * @property string|null $company_id
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereAgeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereAmountCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereAnalysisCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereBenefits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereCalendarCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereClientCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereDeferredCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereEmployee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereInvoiceCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereLawyer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereNewEntry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics wherePendencyCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereRecommendations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereRequirementCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereSchedulesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereSexCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAnalytics whereUpdatedAt($value)
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
