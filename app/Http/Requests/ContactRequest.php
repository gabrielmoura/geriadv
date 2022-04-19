<?php

namespace App\Http\Requests;

use App\Rules\ReCAPTCHAv3Google;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' =>'required|max:255',
            'tel' => 'numeric|required_without:email', //   Deve retornar required caso email esteja vazio
            'email' => 'email|required_without:tel', // Deve retornar required caso tel esteja vazio
            'body' => 'required',
            'grecaptcha' => ['required',new ReCAPTCHAv3Google]
        ];
    }


    /**
     * Get the validation error message.
     *
     * @return string[]
     */
    public function message()
    {
        return [
            'required' => 'Este campo é obrigatório!',
            'min' => 'Campo deve ter no mínimo :min caracteres',
        ];
    }

}
