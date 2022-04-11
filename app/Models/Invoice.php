<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
