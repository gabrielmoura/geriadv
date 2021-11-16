<?php

namespace Database\Factories;

use App\Actions\Client\CreateDocBR;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Pendencies;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName()
            , 'last_name' => $this->faker->lastName()
            , 'company_id' => $this->company()
            , 'user_id' => $this->userId()
            , 'cpf' => $this->faker->cpf(false)
            , 'rg' => $this->faker->rg(false)
            , 'email' => $this->faker->companyEmail()
            , 'tel0' => $this->numberClear($this->faker->areaCode() . $this->faker->landline())
            , 'tel1' => $this->numberClear($this->faker->areaCode() . $this->faker->landline())
            , 'sex' => collect(['m', 'f'])->random()
            , 'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now')
            , 'cep' => $this->numberClear($this->faker->postcode())
            , 'address' => $this->faker->address()
            , 'number' => $this->faker->randomNumber()
            , 'complement' => collect(range('A', 'Z'))->random()
            , 'district' => null
            , 'city' => $this->faker->city()
            , 'state' => $this->faker->stateAbbr()
        ];
    }

    private function userId(): int
    {
        //User::all('id')->random()->id;
        $u = User::factory()->create([
            'name' => $this->faker->userName(),
            'email' => $this->faker->email(),
            'password' => Hash::make('admin'),
            //'adm' => true
        ]);
        $u->assignRole('manager');
        return $u->id;
    }

    private function company()
    {
        $c = Company::all(['id']);
        if (is_null($c)) {
            return null;
        }
        return $c->random()->id;

    }
    private function numberClear($number)
    {
        return preg_replace('/[^0-9]/', '', $number);
    }

}
