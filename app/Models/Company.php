<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $email
 * @property string|null $tel0 telefone
 * @property string|null $name
 * @property string|null $cnpj
 * @property int|null $cep
 * @property string|null $address Endereço
 * @property int|null $number Numero
 * @property string|null $complement Complemento
 * @property string|null $district Bairro
 * @property string|null $city Cidade
 * @property string|null $state Estado
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Employee $employees
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTel0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Company extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['name', 'cnpj', 'cep', 'address', 'number', 'complement', 'district', 'city', 'state', 'email', 'tel0'];
    protected $table = 'companies';

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
    public function employees()
    {
        return $this->belongsTo(Employee::class, 'id', 'company_id');
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

    public function getPaid(): bool
    {
        return true;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
        //->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }
}
