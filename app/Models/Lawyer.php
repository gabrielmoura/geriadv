<?php

namespace App\Models;

use EndyJasmi\Cuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Controle de advogados
 * Class Lawyer
 *
 * @package App\Models
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id Usuário
 * @property string $name
 * @property string|null $last_name
 * @property string|null $cpf
 * @property int|null $oab Inscrição OAB
 * @property string|null $rg
 * @property string|null $email
 * @property string|null $tel0 telefone
 * @property string|null $tel1
 * @property string|null $sex Sexo
 * @property string|null $birth_date Data de nascimento
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @method static \Database\Factories\LawyerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereOab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereRg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereTel0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereTel1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereUserId($value)
 * @mixin \Eloquent
 * @property int $company_id Empresa
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer whereCompanyId($value)
 * @property string $pid Public ID
 * @method static \Illuminate\Database\Eloquent\Builder|Lawyer wherePid($value)
 */
class Lawyer extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'last_name',
        'user_id',
        'cpf',
        'oab',
        'email',
        'tel0',
        'tel1',
        'sex',
        'birth_date',
        'company_id'
        //'cep',
    ];
    protected $dates = ['created_at', 'updated_at'];

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
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName(session()->get('company.name') ?? 'system')->logFillable();
        //->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->pid = Str::ulid();
        });
    }
}
