<?php

namespace Database\Factories;

use App\Actions\Client\CreateDocBR;
use App\Models\Benefits;
use App\Models\Clients;
use App\Models\Company;
use App\Models\Model;
use App\Models\Pendencies;
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
            'name' => $this->faker->name()
            , 'last_name' => $this->faker->lastName()
            , 'tel0' => null
            , 'cpf' => CreateDocBR::cpfRandom(false)
            , 'rg' => null
            , 'sex' => collect(['m', 'f'])->random()
            , 'birth_date' => null
            , 'email' => $this->faker->email()

            /**
             * Dados do Endereço
             */
            , 'cep' => $this->numberClear($this->faker->postcode())
            , 'address' => null
            , 'number' => $this->faker->randomNumber()
            , 'complement' => null

            , 'district' => $this->faker->name()
            , 'city' => $this->faker->name()
            , 'state' => $this->faker->name()

            //, 'country'
            //, 'newsletter'

            //, 'recommendation_id'

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
        //return $c->random()->id; //Retorna ID aleatório
        return 1;

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
            'cras' => collect([true, false])->random()
            , 'cpf' => collect([true, false])->random()
            , 'rg' => collect([true, false])->random()
            , 'birth_certificate' => collect([true, false])->random()
            , 'proof_of_address' => collect([true, false])->random()
            , 'impossibility_to_sign' => collect([true, false])->random()
            // , 'note_id' => null
        ]);
        return $p->id;
    }

    private function numberClear($number)
    {
        return preg_replace('/[^0-9]/', '', $number);
    }
}
