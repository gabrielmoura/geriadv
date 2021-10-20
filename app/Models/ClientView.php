<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\ViewModels\ViewModel;

class ClientView extends Model
{
    //use HasFactory;

    //protected $fillable = [];
    protected $table = 'client_views';
    protected $casts = [
        'cpf' => 'encrypted',
        'rg' => 'encrypted',
    ];


    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */


    /*
    |------------------------------------------------------------------------------------
    | Relations
    |------------------------------------------------------------------------------------
    */

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
