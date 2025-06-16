<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleDeclarationFormController extends Controller
{
    public function index()
    {
        return view('vehicle-declaration-form');
    }
}
