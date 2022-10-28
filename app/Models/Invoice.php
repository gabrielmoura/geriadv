<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $invoiceable_type
 * @property int|null $invoiceable_id
 * @property int|null $client_id Client
 * @property int|null $company_id Company
 * @property \Illuminate\Support\Collection|null $items
 * @property string|null $order_id
 * @property int|null $user_id
 * @property-read Model|\Eloquent $invoiceable
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUserId($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoiceable_id',
        'invoiceable_type',
        'user_id',
        'order_id',
        'items',
        'client_id',
        'company_id',
    ];
    protected $table = 'invoices';
    protected $dates = ['created_at', 'updated_at', 'due_date'];
    protected $casts = [
        'items' => 'collection',
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
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function invoiceable()
    {
        return $this->morphTo();
    }


    /**
     * Retornará informações do Método de pagamento utilizado.
     * @return Model|\Illuminate\Database\Eloquent\Relations\MorphTo|object|null
     */
    public function payment()
    {
        return $this->invoiceable()->first();
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
}
