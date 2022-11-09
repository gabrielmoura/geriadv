<?php

namespace App\Models;

use App\Observers\ClientObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Shetabit\Visitor\Traits\Visitable;
use Illuminate\Database\Eloquent\Prunable;
use Laravel\Scout\Searchable;

/**
 * App\Models\Clients
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $pid Public ID
 * @property int|null $recommendation_id Recomendações
 * @property int|null $pendency_id Pendencias
 * @property int|null $benefit_id Benefícios
 * @property int|null $company_id Empresa
 * @property string|null $name
 * @property string|null $last_name
 * @property mixed $cpf
 * @property mixed|null $rg
 * @property string|null $email
 * @property string|null $tel0 telefone
 * @property string|null $tel1
 * @property string|null $sex Sexo
 * @property string|null $birth_date Data de nascimento
 * @property int|null $cep
 * @property string|null $address Endereço
 * @property int $number Numero
 * @property string|null $complement Complemento
 * @property string $district Bairro
 * @property string $city Cidade
 * @property string $state Estado
 * @property \Illuminate\Support\Collection|null $properties Propriedades
 * @property \Illuminate\Support\Collection $payment Pagamento
 * @property int|null $lawyer_id Advogado
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Benefits|null $benefit
 * @property-read string $full_name
 * @property-read bool $paid
 * @property-read int $parcel
 * @property-read float $parcel_value
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Note|null $note
 * @property-read \App\Models\Pendencies|null $pendency
 * @property-read \App\Models\Recommendation|null $recommendation
 * @property-read \App\Models\ClientStatus|null $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\Shetabit\Visitor\Models\Visit[] $visitLogs
 * @property-read int|null $visit_logs_count
 * @method static \Database\Factories\ClientsFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients newQuery()
 * @method static \Illuminate\Database\Query\Builder|Clients onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients query()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereBenefitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereLawyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients wherePendencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereRecommendationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereRg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereTel0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereTel1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Clients withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Clients withoutTrashed()
 * @mixin \Eloquent
 */
class Clients extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    use SoftDeletes, LogsActivity, Visitable, Prunable;
    use Searchable;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id'
        /**
         * Dados Pessoais
         */
        , 'name'
        , 'last_name'
        , 'tel'
        , 'cpf'
        , 'rg'
        , 'sex'
        , 'birth_date'
        , 'email'

        /**
         * Dados do Endereço
         */
        , 'cep'
        , 'address'
        , 'number'
        , 'complement'
        , 'district'
        , 'city'
        , 'state'
        , 'country'
        , 'newsletter'

        , 'recommendation_id'

        , 'benefit_id'
        , 'company_id'


    ];
    /**
     * @var string[]
     */
    protected $casts = [
        'cpf' => 'encrypted',
        'rg' => 'encrypted',
        'newsletter' => 'boolean',
        'properties' => 'collection',
        'payment' => 'collection'
    ];
    /**
     * @var string[]
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /*
    |------------------------------------------------------------------------------------
    | Relations
    |------------------------------------------------------------------------------------
    */

    /**
     *
     */
    public static function boot()
    {
        parent::boot();
        Clients::observe(ClientObserver::class);
        self::creating(function ($model) {
            $model->pid = Str::ulid();
        });
    }

    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|object|null
     */
    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }

    /**
     * @return string
     */
    public function avatar()
    {
        return "https://ui-avatars.com/api/?rounded=true&size=128&name=" . $this->name . ' ' . $this->last_name;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(ClientStatus::class, 'id', 'client_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function note()
    {
        return $this->belongsTo(Note::class, 'id', 'client_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pendency()
    {
        return $this->belongsTo(Pendencies::class, 'pendency_id', 'id');
    }

    /**
     * Retorna Benefio Requerido
     */
    public function benefit()
    {
        return $this->belongsTo(Benefits::class, 'benefit_id', 'id');
    }


    /**
     * Retorna Indicação do Cliente
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class, 'recommendation_id', 'id');
    }


    /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */
    public function prunable()
    {
        $due_date = config('core.ForgetDeletes');

//        $this->info('Forgetting SoftDeletes');

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

    public function getPaidAttribute(): bool
    {
        return $this->payment->get('paid');
    }

    public function getParcelAttribute(): int
    {
        return $this->payment->get('parcel');
    }

    public function getParcelValueAttribute(): float
    {
        return $this->payment->get('parcel_value');
    }


    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->last_name;
    }

    /**
     * @return LogOptions
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName(session()->get('company.name') ?? 'system')->logFillable();
        //->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }

    public function searchableAs(): string
    {
        return 'clients_index';
    }
}
