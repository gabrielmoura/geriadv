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
use App\Actions\Payment\PaymentTrait;
use Illuminate\Database\Eloquent\Prunable;
use Laravel\Scout\Searchable;

class Clients extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, PaymentTrait;
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
