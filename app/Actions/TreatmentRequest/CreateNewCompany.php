<?php


namespace App\Actions\TreatmentRequest;


use App\Models\LogMovement;
use Illuminate\Http\Request;

class CreateNewCompany
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function update()
    {
        $this->validate();
        $data = $this->request->all();
        $data['cep'] = numberClear($this->request['cep']);
        $data['tel0'] = numberClear($this->request['tel0']);
        $data['cnpj'] = numberClear($this->request['cnpj']);
        $data['config'] = collect([
            'docs' => ['cras', 'cpf', 'rg', 'birth_certificate', 'proof_of_address'],
            'weekend' => false,
            'opening' => '07:00',
            'closing' => '18:00',
        ]);
        return $data;
    }

    public function store()
    {
        $this->validate();
        $data = $this->request->all();
        $data['cep'] = numberClear($this->request['cep']);
        $data['tel0'] = numberClear($this->request['tel0']);
        $data['cnpj'] = numberClear($this->request['cnpj']);
        $data['config'] = collect([
            'docs' => ['cras', 'cpf', 'rg', 'birth_certificate', 'proof_of_address'],
            'weekend' => false,
            'opening' => '07:00',
            'closing' => '18:00',
        ]);
        return $data;
    }

    private function validate()
    {
        $this->request->validate([
            /**
             * Dados
             */
            'name' => 'required|min:3'
        ]);
    }
}
