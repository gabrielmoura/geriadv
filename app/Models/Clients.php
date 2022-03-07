<?php

namespace App\Models;

use App\Observers\ClientObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Shetabit\Visitor\Traits\Visitable;
use App\Actions\Payment\PaymentTrait;
/**
 * App\Models\Clients
 *
 * @property-read string $full_name
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Clients newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property int|null $recommendation_id Recomendações
 * @property int|null $benefit_id Benefícios
 * @property string|null $name
 * @property string|null $last_name
 * @property mixed $doc
 * @property int|null $tel0 telefone
 * @property string $tel1
 * @property string|null $sex Sexo
 * @property string|null $birth_date Data de nascimento
 * @property int|null $cep
 * @property string|null $address Endereço
 * @property int $number Numero
 * @property string|null $complement Complemento
 * @property string $district Bairro
 * @property string $city Cidade
 * @property string $state Estado
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereBenefitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereRecommendationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereTel0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereTel1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property mixed $cpf
 * @property mixed|null $rg
 * @property string|null $email
 * @property-read \App\Models\Benefits $benefits
 * @property-read mixed $birth_certificate
 * @property-read mixed $down_c_p_f
 * @property-read mixed $down_r_g
 * @property-read mixed $proof_of_address
 * @property-read \App\Models\LogMovement $log
 * @property-read \App\Models\Note $note
 * @property-read \App\Models\Recommendation $recommendation
 * @property-read \App\Models\ClientStatus $status
 * @method static \Illuminate\Database\Query\Builder|Clients onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereRg($value)
 * @method static \Illuminate\Database\Query\Builder|Clients withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Clients withoutTrashed()
 * @property int|null $pendency_id Pendencias
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Pendencies|null $pendency
 * @method static \Illuminate\Database\Eloquent\Builder|Clients wherePendencyId($value)
 * @property int|null $company_id Empresa
 * @property-read \App\Models\Benefits|null $benefit
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $testMany
 * @property-read int|null $test_many_count
 * @method static \Database\Factories\ClientsFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCompanyId($value)
 * @property \Illuminate\Support\Collection|null $properties Propriedades
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereProperties($value)
 */
class Clients extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia,PaymentTrait;
    use HasSlug, SoftDeletes, LogsActivity, Visitable;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function testMany()
    {
        return $this->belongsToMany(
            User::class,
            'trophies_users',
            'trophy_id',
            'user_id');

    }

    /**
     * Retorna Indicação do Cliente
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class, 'recommendation_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getDownCPFAttribute()
    {
        //return $this->photos()->first()->full;
        return $this->getMedia('product')->first()->getUrl('full');
    }

    /**
     * @return mixed
     */
    public function getDownRGAttribute()
    {
        //return $this->photos()->first()->full;
        return $this->getMedia('product')->first()->getUrl('full');
    }

    /**
     * @return mixed
     */
    public function getBirth_certificateAttribute()
    {
        //return $this->photos()->first()->full;
        return $this->getMedia('product')->first()->getUrl('full');
    }

    /*
        |------------------------------------------------------------------------------------
        | Scopes
        |------------------------------------------------------------------------------------
        */

    /**
     * @return mixed
     */
    public function getProof_of_addressAttribute()
    {
        //return $this->photos()->first()->full;
        return $this->getMedia('product')->first()->getUrl('full');
    }

    /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */

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
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('last_name')
            ->saveSlugsTo('slug');
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
}
