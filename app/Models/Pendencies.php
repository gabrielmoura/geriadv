<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pendencies
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $cras CRAS
 * @property mixed $cpf CPF
 * @property mixed $rg RG
 * @property mixed $birth_certificate Certidão de Nascimento
 * @property mixed $proof_of_address Comprovante de Residencia
 * @property mixed $impossibility_to_sign Impossibilitado de assinar
 * @property int|null $note_id Observações associadas
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies whereBirthCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies whereCras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies whereImpossibilityToSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies whereNoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies whereProofOfAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies whereRg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pendencies whereUpdatedAt($value)
 */
class Pendencies extends Model
{
    use HasFactory;

    protected $fillable = [
        'cras',
        'cpf',
        'rg',
        'birth_certificate',
        'proof_of_address',
        'impossibility_to_sign',
        'note_id'
    ];
}
