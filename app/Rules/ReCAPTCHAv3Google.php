<?php

namespace App\Rules;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Validation\Rule;

class ReCAPTCHAv3Google implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $client = new Client();
        try {
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => config('recaptcha.v3.private_key'),
                    'response' => $value,
                    'remoteip' => Request::ip(),
                ],
            ]);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return false;
        }
        return $this->getScore($response) >= config('recaptcha.v3.minimum_score');
    }
    private function getScore($response)
    {
        return json_decode($response->getBody(), true)['score'];
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Failed on reCAPTCHA verification.';
    }
}
