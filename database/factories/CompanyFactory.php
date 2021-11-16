<?php

namespace Database\Factories;

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
            'name' => $this->faker->firstName() .' '. $this->faker->lastName() . ' company ' . $this->faker->randomNumber(1)
            , 'cnpj' => $this->faker->cnpj(false)
            , 'cep' => $this->numberClear($this->faker->postcode())
            , 'address' => $this->faker->address()
            , 'number' => $this->faker->randomNumber(3)
            , 'complement' => collect(range('A', 'Z'))->random()
            , 'district' => null
            , 'city' => $this->faker->city()
            , 'state' => $this->faker->stateAbbr()
            , 'email' => $this->faker->email()
            , 'tel0' => $this->numberClear($this->faker->areaCode() . $this->faker->landline())
        ];
    }

    private function numberClear($number)
    {
        return preg_replace('/[^0-9]/', '', $number);
    }
}
