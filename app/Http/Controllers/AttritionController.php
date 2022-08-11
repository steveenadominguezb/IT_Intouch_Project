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
            $cde_user = request('cde');
            $user = User::where('name', 'LIKE', '%' . $name_user . '%')
                ->get();
            if (sizeof($user) >= 1) {
                if (sizeof($user) == 1) {
                    $wave_employee = WaveEmployee::where('cde', $user[0]->cde)->first();
                } else {
                    if ($cde_user) {
                        $user = User::where('name', 'LIKE', '%' . $name_user . '%')->where('cde', $cde_user)->first();
                        if (!$user) {
                            return back()->with(['message' => 'invalid employee code', 'alert' => 'warning']);
                        }
                        $wave_employee = WaveEmployee::where('cde', $user->cde)->first();
                    } else {
                        return back()->with(['message' => 'There are many records with the same name, please try again and enter the employee code', 'alert' => 'warning']);
                    }
                }
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
                    return back()->with(['message' => 'This user(' . $name_user . ') is not assigned to a wave', 'alert' => 'warning']);
                }
            } else {
                return back()->with(['message' => 'This user(' . $name_user . ') is not already registered', 'alert' => 'warning']);
            }
            return back();
        } catch (\Throwable $th) {
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }

    public function update()
    {
        try {
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
                case 'exchange':
                    $attrition = Attrition::find(request('id'));

                    if (request('new_host') == null) {
                        return back()->with(['message' => 'Enter the workstation of the new computer', 'alert' => 'warning']);
                    }


                    if (request('serial') && request('returned') == 'yes') {
                        $computer = Computer::where('SerialNumber', request('serial'))->first();
                        $computer->Status = "InStorage";
                        $computer->save();

                        $attrition->hardware_returned = request('returned');
                        $attrition->tested_date = now();
                        $attrition->save();
                    }

                    $new_computer = Computer::where('HostName', request('new_host'))->first();
                    if (!$new_computer || $new_computer->Status != "InStorage") {
                        return back()->with(['message' => "This computer (" . request('new_host') . ") is not registered or is already deployed", 'alert' => 'warning']);
                    }

                    $wave_employee = WaveEmployee::where('cde', request('cde'))->first();
                    $wave_employee->SerialNumberComputer = $new_computer->SerialNumber;
                    $new_computer->Status = "Deployed";
                    $new_computer->save();
                    $wave_employee->save();

                    $attrition->wfs_attrition = request('wfs');
                    $attrition->hardware_returned = request('returned');
                    $attrition->tested_date = now();
                    $attrition->NewSerialNumber = $new_computer->SerialNumber;
                    $attrition->save();

                    return back();

                    break;
                default:
                    return back()->with(['message' => 'select a option: attrition or work on site in wfs-attrition', 'alert' => 'warning']);
                    break;
            }
            return back()->with(['message' => 'Success', 'alert' => 'success']);
        } catch (\Throwable $th) {
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }

        return back();
    }

    public function deleteUser()
    {
        try {
            $attrition = Attrition::find(request('id'))->delete();
            return back()->with(['message' => 'Success', 'alert' => 'success']);
        } catch (\Throwable $th) {
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }

    public function addComment()
    {
        try {

            $attrition = Attrition::find(request('id'));
            $attrition->comments = request('comment');
            $attrition->save();

            return back()->with(['message' => 'Comment added', 'alert' => 'success']);
        } catch (\Throwable $th) {
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }
}
