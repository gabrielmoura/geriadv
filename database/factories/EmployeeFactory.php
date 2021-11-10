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
            'name' => $this->faker->name()
            , 'last_name' => $this->faker->lastName()
            , 'company_id' => $this->company()
            , 'user_id' => $this->userId()
            , 'cpf' => CreateDocBR::cpfRandom()
            , 'rg' => null
            , 'email' => $this->faker->companyEmail()
            , 'tel0' => null
            , 'tel1' => null
            , 'sex' => collect(['m', 'f'])->random()
            , 'birth_date' => null
            , 'cep' => null
            , 'address' => null
            , 'number' => null
            , 'complement' => null
            , 'district' => null
            , 'city' => null
            , 'state' => null
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


}
