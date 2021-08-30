<?php

namespace App\Http\Requests;

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
            'address' => ''
            , 'email' => 'required|email'
            , 'tel' => ''
            , 'body' => 'required|min:30'
            , 'g-recaptcha-response' => 'required|captcha'
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
