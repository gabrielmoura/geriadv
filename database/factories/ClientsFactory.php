<?php

namespace Database\Factories;

use App\Models\Benefits;
use App\Models\Clients;
use App\Models\Company;
use App\Models\Model;
use App\Models\Pendencies;
use App\Models\Recommendation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Clients::class;

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
            , 'tel0' => $this->numberClear($this->faker->areaCode() . $this->faker->landline())
            , 'cpf' => $this->faker->cpf(false)
            , 'rg' => $this->faker->rg(false)
            , 'sex' => collect(['m', 'f'])->random()
            , 'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now')
            , 'email' => $this->faker->email()

            /**
             * Dados do Endereço
             */
            , 'cep' => $this->numberClear($this->faker->postcode())
            , 'address' => $this->faker->address()
            , 'number' => $this->faker->randomNumber()
            , 'complement' => collect(range('A', 'Z'))->random()

            , 'district' => $this->faker->city()
            , 'city' => $this->faker->city()
            , 'state' => $this->faker->stateAbbr()

            //, 'country'
            //, 'newsletter'

            , 'recommendation_id' => $this->recommendation()

            , 'benefit_id' => $this->benefit()
            , 'company_id' => $this->company()
            , 'pendency_id' => $this->pendency()
        ];
    }

    private function company()
    {
        $c = Company::all(['id']);
        if (is_null($c)) {
            return null;
        }
        return $c->random()->id; //Retorna ID aleatório
    }

    private function benefit()
    {
        $b = Benefits::all(['id']);
        if (is_null($b)) {
            return null;
        }
        return $b->random()->id;
    }

    private function pendency()
    {
        $p = Pendencies::create([
            'pendency' => [
                'cras' => collect([true, false])->random()
                , 'cpf' => collect([true, false])->random()
                , 'rg' => collect([true, false])->random()
                , 'birth_certificate' => collect([true, false])->random()
                , 'proof_of_address' => collect([true, false])->random()
                , 'impossibility_to_sign' => collect([true, false])->random()
                // , 'note_id' => null
            ]]);
        return $p->id;
    }

    private function recommendation()
    {
        $r = Recommendation::create([
            'name' => $this->faker->firstName
        ]);
        return $r->id;
    }

    private function numberClear($number)
    {
        return preg_replace('/[^0-9]/', '', $number);
    }
}
