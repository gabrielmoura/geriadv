<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\ViewModels\ViewModel;

/**
 * App\Models\ClientView
 *
 * @property int|null $id
 * @property mixed|null $cpf
 * @property string|null $last_name
 * @property string|null $name
 * @property mixed|null $rg
 * @property string|null $email
 * @property string|null $tel0
 * @property string|null $sex
 * @property string|null $birth_date
 * @property int|null $cep
 * @property string|null $address
 * @property int|null $number
 * @property string|null $complement
 * @property string|null $district
 * @property string|null $city
 * @property string|null $state
 * @property string|null $benefit
 * @property string|null $status
 * @property bool|null $pendency_cras
 * @property bool|null $pendency_cpf
 * @property bool|null $pendency_rg
 * @property bool|null $pendency_birth_certificate
 * @property bool|null $pendency_proof_of_address
 * @property bool|null $pendency_impossibility_to_sign
 * @property string|null $note
 * @property string|null $recommendation
 * @property string|null $tel1
 * @property string|null $slug
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereBenefit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView wherePendencyBirthCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView wherePendencyCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView wherePendencyCras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView wherePendencyImpossibilityToSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView wherePendencyProofOfAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView wherePendencyRg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereRecommendation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereRg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereTel0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientView whereTel1($value)
 * @mixin \Eloquent
 */
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
