<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\User;
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

                $dir_subida = 'files/computers/';
                $fichero_subido = $dir_subida . basename($_FILES['file']['name']);

                if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {

                    $csv = array_map('str_getcsv', file('files/computers/' . $_FILES['file']['name']));
                    array_walk($csv, function (&$a) use ($csv) {
                        $a = array_combine($csv[0], $a);
                    });
                    array_shift($csv);
                    foreach ($csv as $computer_data) {
                        $computer = new Computer();
                        $computer->SerialNumber = $computer_data['SerialNumber'];
                        $computer->HostName = $computer_data['HostName'];
                        $computer->OS = $computer_data['OS'];
                        $computer->Brand = $computer_data['Brand'];
                        $computer->Model = $computer_data['Model'];
                        if ($computer_data['isLaptop'] == "YES") {
                            $computer->Laptop = true;
                        } else {
                            $computer->Laptop = false;
                        }


                        $computer->save();
                    }
                    echo '<script language="javascript">alert("Successful");</script>';
                } else {
                    return "¡Posible ataque de subida de ficheros!\n";
                }

                return view('register_computer');
            }
        } catch (\Throwable $th) {
            echo '<script language="javascript">alert("Error: , try again.");</script>';
            $wait = "";
            return view('register_computer');
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


        return back();
    }

    public function computersList()
    {   
        $text = trim(request('text'));
        if ($text != null) {
            $computers = Computer::where('SerialNumber', 'LIKE', '%' . $text . '%')->where('Status', 'InStorage')->get();
            if ($computers->isEmpty()) {
                $computers = Computer::where('HostName', 'LIKE', '%' . $text . '%')->where('Status', 'InStorage')->get();
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
            return back()->with(['message' => 'Error, try again', 'alert' => 'danger']);
        }
    }

    public function computerTracert($SerialNumber){
        $computer = Computer::where('SerialNumber', $SerialNumber)->get();
        return $computer;
    }
}
