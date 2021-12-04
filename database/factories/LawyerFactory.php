<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class LawyerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lawyer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $email = $this->faker->companyEmail();
        return [
            'name' => $this->faker->firstName()
            , 'last_name' => $this->faker->lastName()
            , 'user_id' => $this->userId($email)
            , 'company_id' => $this->companyId()
            , 'cpf' => $this->faker->cpf(false)
            , 'rg' => $this->faker->rg(false)
            , 'oab' => $this->faker->randomNumber(4)
            , 'email' => $email
            , 'tel0' => $this->numberClear($this->faker->areaCode() . $this->faker->landline())
            , 'tel1' => $this->numberClear($this->faker->areaCode() . $this->faker->landline())
            , 'sex' => collect(['m', 'f'])->random()
            , 'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now')
        ];
    }

    private function userId($email): int
    {
        //User::all('id')->random()->id;
        $u = User::factory()->create([
            'name' => $this->faker->userName(),
            'email' => $email ?? $this->faker->email(),
            'password' => Hash::make('admin'),
            //'adm' => true
        ]);
        return $u->id;
    }

    private function companyId()
    {
        return Company::all()->random()->id;
    }

    private function numberClear($number)
    {
        return preg_replace('/[^0-9]/', '', $number);
    }
}
