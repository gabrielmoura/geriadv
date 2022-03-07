<?php

namespace App\Http\Requests\Financial;

use Illuminate\Foundation\Http\FormRequest;

class BilletsRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'parcel' => 'required',
            'description' => 'required',
            'price' => 'required',
            //'quantity' => 'required',

            'client_id'=>'required'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
