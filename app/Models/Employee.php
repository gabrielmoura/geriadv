<?php

namespace App\Models;

use App\Traits\EmployeeTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Employee
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id Usuário
 * @property int $company_id Empresa
 * @property string|null $name
 * @property string|null $last_name
 * @property mixed|null $cpf
 * @property string|null $rg
 * @property string|null $email
 * @property string|null $tel0 telefone
 * @property string|null $tel1
 * @property string|null $sex Sexo
 * @property string|null $birth_date Data de nascimento
 * @property int|null $cep
 * @property string|null $address Endereço
 * @property int|null $number Numero
 * @property string|null $complement Complemento
 * @property string|null $district Bairro
 * @property string|null $city Cidade
 * @property string|null $state Estado
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTel0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTel1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\EmployeeFactory factory(...$parameters)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Employee withoutTrashed()
 */
class Employee extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use EmployeeTraits;

    protected $casts = [
        'cpf' => 'encrypted',
        'cep' => 'integer',
        'name' => 'string',
        'last_name' => 'string',
        //   'birth_date' => 'date',
        'number' => 'integer',
        'complement' => 'string'
    ];

    protected $fillable = [
        'name',
        'last_name',
        'company_id',
        'user_id',
        'cpf',
        'rg',
        'email',
        'tel0',
        'tel1',
        'sex',
        'birth_date',
        'cep',
        'address',
        'number',
        'complement',
        'district',
        'city',
        'state',];
    protected $table = 'employees';
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
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName(session()->get('company.name') ?? 'system')->logFillable();
        //->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }

    protected static function boot()
    {
        parent::boot();
    }
}
