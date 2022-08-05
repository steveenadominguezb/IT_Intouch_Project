<?php

namespace App\Http\Controllers;

use App\Models\Attrition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $attritions = DB::table('attritions')->latest()->get();
        return view('attrition', compact('attritions'));
    }
}
