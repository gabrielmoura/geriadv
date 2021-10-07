<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'cpf' => 'encrypted',
    ];

    protected $fillable = ['name'];
    protected $table='employees';
 /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id=null)
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
    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
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
        return LogOptions::defaults()
            ->logFillable();
        //->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }
}