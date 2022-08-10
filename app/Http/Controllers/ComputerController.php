<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\User;
use App\Models\WaveEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ComputerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('auth');
    }
    /**
     * Show the view
     */
    public function index()
    {
        if (Auth::user()->privilege != 10001) {
            return "No Admin Privileges";
        }
        return view('register_computer');
    }

    /**
     * Create a new computer instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Computer
     */

    protected function create()
    {
        try {
            if ($_FILES['file']['size'] > 0 && $_FILES['file']['type'] == 'text/csv') {
                $fails = 'This Computers is already registered: ';
                $count_fails = 0;
                $registered = false;
                $count = 0;
                $dir_subida = 'files/computers/';
                $fichero_subido = $dir_subida . basename($_FILES['file']['name']);

                if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {

                    $csv = array_map('str_getcsv', file('files/computers/' . $_FILES['file']['name']));
                    array_walk($csv, function (&$a) use ($csv) {
                        $a = array_combine($csv[0], $a);
                    });
                    array_shift($csv);
                    foreach ($csv as $computer_data) {
                        $resultComputer = DB::table('computers')->where('SerialNumber', $computer_data['Serial'])->get();

                        $computer = new Computer();
                        $computer->SerialNumber = $computer_data['Serial'];
                        $computer->HostName = $computer_data['Workstation'];
                        $computer->OS = $computer_data['OS'];
                        $computer->Brand = $computer_data['Brand'];
                        $computer->Model = $computer_data['Model'];
                        if ($computer_data['isLaptop'] == "YES") {
                            $computer->Laptop = true;
                        } else {
                            $computer->Laptop = false;
                        }

                        if (sizeof($resultComputer) != 0 || $computer_data['Serial'] == "") {
                            $registered = true;
                            $count_fails++;
                            $fails .= $computer_data['Serial'] . ' - ' . $computer_data['Workstation'] . '; ';
                        } else {
                            $count++;
                            $computer->save();
                        }
                    }
                    if ($registered) {
                        $mes = explode(":", $fails);
                        return back()->with(['message' => $count . ' computers successfully registered. ', 'th' => $fails, 'alert' => 'warning', 'mes' => $mes, 'fails' => $count_fails]);
                    }
                    return back()->with(['message' => $count . ' computers successfully registered. ', 'alert' => 'success']);
                } else {
                    return "¡Possible file upload attack!\n";
                }

                return view('register_computer');
            }
        } catch (\Throwable $th) {
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }

        /**
         * Valida que los campos necesarios hayan sido diligenciados
         */
        $this->validate(request(), [
            'serial' => 'required',
            'host' => 'required',
            'os' => 'required',
            'brand' => 'required',
            'model' => 'required'
        ]);

        #Comprueba que el computador no esté registrado ya
        $resultComputer = DB::table('computers')->where('SerialNumber', request('serial'))->get();
        if (sizeof($resultComputer) == 1) {
            return back()->with(['message' => 'Error, ' . request('serial') . ' - ' . request('host') . ' is already registered', 'alert' => 'danger']);
        }

        /**
         * Crea una instancia computer
         */
        $computer = new Computer();
        $computer->SerialNumber = request('serial');
        $computer->HostName = request('host');
        $laptop = request('laptop');
        if ($laptop) {
            $computer->Laptop = true;
        } else {
            $computer->Laptop = false;
        }

        $computer->Model = request('model');
        $computer->OS = request('os');
        $computer->Brand = request('brand');
        $computer->Status = 'InStorage';

        #Guarda el computer
        $computer->save();


        return back()->with(['message' => 'Successful', 'alert' => 'success']);
    }

    public function computersList()
    {
        $text = trim(request('text'));
        if ($text != null) {
            $computers = Computer::where('SerialNumber', 'LIKE', '%' . $text . '%')->get();
            if ($computers->isEmpty()) {
                $computers = Computer::where('HostName', 'LIKE', '%' . $text . '%')->get();
            }
            if ($computers->isEmpty()) {
                $computers = Computer::where('Status', 'LIKE', '%' . $text . '%')->get();
            }
            return view('computers', compact('computers'));
        }

        $computers = Computer::all();
        return view('computers', compact('computers'));
    }

    public function computersUpdate()
    {
        try {
            $laptop = request('laptop') == 'on' ? true : false;
            DB::table('computers')->where('SerialNumber', request('serial'))
                ->update([
                    'HostName' => request('host'),
                    'OS' => request('os'),
                    'OS' => request('os'),
                    'Brand' => request('brand'),
                    'Model' => request('model'),
                    'Laptop' => $laptop,
                ]);
            return back()->with(['message' => 'Updated', 'alert' => 'success']);
        } catch (\Throwable $th) {
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }

    public function computerTracert($SerialNumber)
    {
        $computer = Computer::where('SerialNumber', $SerialNumber)->first();
        $waves_computer = WaveEmployee::where('SerialNumberComputer', $SerialNumber)->latest()->get();
        return view('computer_tracert', compact('computer', 'waves_computer'));
    }

    public function inBlackList($SerialNumber)
    {
        try {
            $computer =  DB::table('computers')->where('SerialNumber', $SerialNumber)->get();
            if ($computer[0]->Status != 'InBlackList') {
                DB::table('computers')->where('SerialNumber', $SerialNumber)
                    ->update(['Status' => 'InBlackList']);
                return back()->with(['message' => 'Updated', 'alert' => 'success']);
            } else {
                DB::table('computers')->where('SerialNumber', $SerialNumber)
                    ->update(['Status' => 'InStorage']);
                return back()->with(['message' => 'Updated', 'alert' => 'success']);
            }
        } catch (\Throwable $th) {
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }
}
