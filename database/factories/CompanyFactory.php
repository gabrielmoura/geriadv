<?php

namespace Database\Factories;

use App\Actions\Client\CreateDocBR;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'company' . $this->faker->randomNumber(1)
            , 'cnpj' => CreateDocBR::cnpjRandom(false)
            , 'cep' => $this->numberClear($this->faker->postcode())
            , 'address' => null
            , 'number' => null
            , 'complement' => null
            , 'district' => null
            , 'city' => null
            , 'state' => null
            , 'email' => null
            , 'tel0' => null
        ];
    }

    private function numberClear($number)
    {
        return preg_replace('/[^0-9]/', '', $number);
    }
}
