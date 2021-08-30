<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = ContactRequest::where('read', false)->get();
        return view('admin.contact.index', compact('contacts'));
    }
}
