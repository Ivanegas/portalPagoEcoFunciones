<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function login(){
        return view('login');
    }

    public function inicio(){
        return view('index');
    }

    public function miPerfil(){
        return view('perfil');
    }

    public function misFacturas(){
        return view('facturas');
    }
}
