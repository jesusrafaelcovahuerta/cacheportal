<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RutController extends Controller
{
    public function index()
    {
        return view('auth.rut');
    }
}
