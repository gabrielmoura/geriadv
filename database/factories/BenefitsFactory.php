<?php

namespace Database\Factories;

use App\Models\Benefits;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class BenefitsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Benefits::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->name()
            , 'description' => $this->faker->title()
            , 'company_id' => $this->company()
            , 'wage' => 10.00 // Remuneração
            , 'wage_factor' => null // Fator de Remuneração
            , 'wage_type' => null //Tipo de Remuneração
        ];
    }

    private function name()
    {
        $data = collect(['aposentadoria', 'niver', 'loas']);
        return $data->random();
    }

    private function company()
    {
        $c = Company::all(['id']);
        if (is_null($c)) {
            return null;
        }
        return $c->random()->id;

    }
}
