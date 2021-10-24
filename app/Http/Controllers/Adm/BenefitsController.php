<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Benefits;
use Illuminate\Http\Request;

/**
 * Gerenciamento de Beneficios
 * Class BenefitsController
 * @package App\Http\Controllers\Adm
 */
class BenefitsController extends Controller
{
    public function index(){
        Benefits::where()->get();
        return view('');
    }
    public function edit(){
        return view('');
    }
    public function show(){
        return view('');
    }
    public function update(){}
    public function delete(){}
    public function store(){}
}
