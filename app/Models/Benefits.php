<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Benefits
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereUpdatedAt($value)
 * @property int $client_id Cliente
 * @property int|null $user_id Funcionário
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereUserId($value)
 * @property string $wage Remuneração
 * @property int|null $company_id Empresa
 * @property float|null $wage_factor Fator de Remuneração
 * @property string|null $wage_type Tipo de Remuneração
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Clients[] $clients
 * @property-read int|null $clients_count
 * @method static \Database\Factories\BenefitsFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereWageFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefits whereWageType($value)
 */
class Benefits extends Model
{
    use HasFactory;
    use LogsActivity;


    protected $fillable = ['name', 'description', 'company_id', 'wage', 'wage_factor', 'wage_type'];


    public function clients()
    {
        return $this->hasMany(Clients::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName(session()->get('company.name') ?? 'system')->logFillable();
        //->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }
}
