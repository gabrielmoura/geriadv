<?php


namespace App\Actions\Payment\PagHiper;

use App\Models\Clients;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;


class Billets extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_id',
        'order_id',
        'status',
        'quantity',
        'items',
        'value_cents',
        'notification_id',
        'client_id',
        'company_id',

        'bank_slip', //json
        'due_date' //Data de Vencimento
    ];
    protected $table = 'billets';
    protected $casts = [
        'items' => 'collection',
        'bank_slip' => 'collection',
        'due_date' => 'datetime:d/m/YH:00',
    ];
    protected $dates = ['created_at', 'updated_at', 'due_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->hasOne(Clients::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }
    public function clients(){
        return $this->belongsTo(Clients::class,'client_id','id');
    }

}
