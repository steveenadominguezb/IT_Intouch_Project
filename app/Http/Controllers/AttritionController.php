<?php

namespace App\Http\Controllers;

use App\Models\Attrition;
use App\Models\User;
use App\Models\WaveEmployee;
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
        $rows = Attrition::latest()->get();
        return view('attrition', compact('rows'));
    }

    public function store()
    {
        try {
            $name_user = request('name_user');
            $user = User::where('name', 'LIKE', '%' . $name_user . '%')
                ->first();
            if ($user) {
                $wave_employee = WaveEmployee::where('cde', $user->cde)->first();
                if ($wave_employee) {

                    $attrition = new Attrition();
                    $attrition->cde = $wave_employee->cde;
                    $attrition->IdProgram = $wave_employee->parent->parent->programs->IdProgram;
                    if ($wave_employee->SerialNumberComputer != null) {
                        $attrition->SerialNumber = $wave_employee->SerialNumberComputer;
                    }
                    $attrition->attrition_date = now();
                    $attrition->save();
                }else{
                    return "This user is not assigned to wave";
                }
            }else{
                return "This User is not already registered";
            }
            return back();
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
