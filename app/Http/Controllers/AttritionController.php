<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttritionController extends Controller
{
    /**
     * Metodo contructor que valida el inicio de sesion
     * y los privilegios necesarios para acceder
     */
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('auth');
    }

    public function index()
    {
        return view('attrition');
    }
}
