<?php

namespace App\Http\Controllers;

use App\Models\Attrition;
use App\Models\Computer;
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
                } else {
                    return "This user is not assigned to wave";
                }
            } else {
                return "This User is not already registered";
            }
            return back();
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update()
    {
        switch (request('wfs')) {
            case 'attrition':

                $wave_employee = WaveEmployee::where('cde', request('cde'))->first();
                $wave_employee->attrition = true;
                $wave_employee->save();

                $user = User::where('cde', request('cde'))->first();
                $user->status = "Inactive";
                $user->save();

                if (request('serial') && request('returned') == 'yes') {
                    $computer = Computer::where('SerialNumber', request('serial'))->first();
                    $computer->Status = "InStorage";
                    $computer->save();
                }

                $attrition = Attrition::find(request('id'));
                $attrition->wfs_attrition = request('wfs');
                $attrition->hardware_returned = request('returned');
                $attrition->tested_date = now();
                $attrition->save();

                return back();

                break;
            case 'wfs':
                if (request('new_host') == null) {
                    return "error, do not have a new host";
                }

                if (request('serial') && request('returned') == 'yes') {
                    $computer = Computer::where('SerialNumber', request('serial'))->first();
                    $computer->Status = "InStorage";
                    $computer->save();
                }

                $new_computer = Computer::where('HostName', request('new_host'))->first();
                if (!$new_computer) {
                    return "This computer is not exist";
                }

                $wave_employee = WaveEmployee::where('cde', request('cde'))->first();
                $wave_employee->SerialNumberComputer = $new_computer->SerialNumber;
                $new_computer->Status = "Taken";
                $new_computer->save();
                $wave_employee->save();

                $attrition = Attrition::find(request('id'));
                $attrition->wfs_attrition = request('wfs');
                $attrition->hardware_returned = request('returned');
                $attrition->tested_date = now();
                $attrition->NewSerialNumber = $new_computer->SerialNumber;
                $attrition->save();

                return back();

                break;
            default:
                return "select a option: attrition or work on site";
                break;
        }
        return back();
    }
}
