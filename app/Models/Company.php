<?php

namespace App\Models;

use App\Observers\CompanyObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Clients[] $clients
 * @property-read int|null $clients_count
 * @property-read int|null $employees_count
 * @method static \Database\Factories\CompanyFactory factory(...$parameters)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Collection $config Configuração
 * @property string|null $logo
 * @property bool $banned Banido
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Query\Builder|Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereConfig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|Company withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Company withoutTrashed()
 */
class Company extends Model implements HasMedia
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use InteractsWithMedia;
    use Prunable;

    protected $fillable = ['name', 'cnpj', 'cep', 'address', 'number', 'complement', 'district', 'city', 'state', 'email', 'tel0', 'logo', 'config'];
    protected $table = 'companies';
    protected $casts = [
        'config' => 'collection'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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

    public function clients()
    {
        return $this->hasMany(Clients::class);
    }

    /**
     * @return array
     */
    public function users()
    {
        return $this->employees()->with('user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id', 'id');
    }

    public function lawyers()
    {
        return $this->hasMany(Lawyer::class, 'company_id', 'id');
    }

    public function calendars()
    {
        return $this->hasMany(Calendar::class, 'company_id', 'id');
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
    public function prunable()
    {
        $due_date = config('core.ForgetDeletes');

        $this->info('Forgetting SoftDeletes');

        if ($due_date == 'yearly') {
            $sub_date = now()->subYear();
        } elseif ($due_date == 'monthly') {
            $sub_date = now()->subMonth();
        } elseif ($due_date == 'weekly') {
            $sub_date = now()->subWeek();
        } else {
            $sub_date = now()->subDays(3);
        }
        //return static::where('deleted_at', '>=', now()->subWeek());
        return $this->where('deleted_at', '>=', $sub_date);
    }

//    protected function pruning()
//    {
//         Remove the associated file from S3 before deleting the model
//        Storage::disk('s3')->delete($this->filename)
//    }

    public function getPaid(): bool
    {
        return true;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName(session()->get('company.name') ?? 'system')->logFillable();
        //->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }

    public static function boot()
    {
        parent::boot();
        Company::observe(CompanyObserver::class);
    }
}
