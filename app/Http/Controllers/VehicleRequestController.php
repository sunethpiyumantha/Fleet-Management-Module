<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleRequestController extends Controller
{
    public function index()
    {
    return view('request-vehicle');
    }
}
