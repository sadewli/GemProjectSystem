<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index()
    {
        return view('crm.contacts');
    }
    public function import()
    {
        return view('crm.contacts-import');
    }
}
