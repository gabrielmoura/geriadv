<?php


namespace App\Actions\TreatmentRequest;


use App\Models\LogMovement;
use App\Traits\CompanySessionTraits;
use Illuminate\Http\Request;

class CreateNewLawyer
{
    use CompanySessionTraits;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function update()
    {
        $this->validate();
        $data = $this->request->all();
        $data['company_id'] = $this->getCompanyId();
        $data['cep'] = numberClear($this->request['cep']);
        $data['tel0'] = numberClear($this->request['tel0']);
        $data['oab'] = numberClear($this->request['oab']);
        $data['cpf'] = numberClear($this->request['cpf']);
        return $data;
    }

    public function store()
    {
        $this->validate();
        $data = $this->request->all();
        $data['company_id'] = $this->getCompanyId();
        $data['cep'] = numberClear($this->request['cep']);
        $data['tel0'] = numberClear($this->request['tel0']);
        $data['oab'] = numberClear($this->request['oab']);
        $data['cpf'] = numberClear($this->request['cpf']);

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
