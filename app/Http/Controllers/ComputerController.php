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
     * Create a new controller instance with privileges validations.
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
        // Valida que tenga los permisos de administrador para mostrar la vista
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
            // Comprueba que si se subió algun archivo y el tipo de archivo
            if ($_FILES['file']['size'] > 0 && $_FILES['file']['type'] == 'text/csv') {
                // Declara una variable fails que indica los computadores que ya están registrados
                $fails = 'This Computers is already registered: ';
                // Declara una variable para llevar la cuenta de los computadores ya registrados
                $count_fails = 0;
                // Declara una variable que indica que se encontraron computadores ya registrados
                $registered = false;
                // Declara una variable para saber cuantos computadores nuevos se van a registrar
                $count = 0;
                // Se establece el directorio de subida del archivo entrante
                $dir_subida = 'files/computers/';
                // Se establece el directorio completo de la ubicacion del archivo
                $fichero_subido = $dir_subida . basename($_FILES['file']['name']);

                // Se valida y mueve el archivo subido al directorio suministrado
                if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {

                    // Se mapea el archivo, leyendolo y almacenandolo en una variable tipo array
                    $csv = array_map('str_getcsv', file('files/computers/' . $_FILES['file']['name']));
                    array_walk($csv, function (&$a) use ($csv) {
                        $a = array_combine($csv[0], $a);
                    });
                    array_shift($csv);
                    // Se recorre el array con la información del archivo
                    foreach ($csv as $computer_data) {
                        // Busca computadores que tenga el serial leído
                        $resultComputer = DB::table('computers')->where('SerialNumber', str_replace(" ", "", $computer_data['Serial']))->orWhere('Hostname', str_replace(" ", "", $computer_data['Workstation']))->get();
                        // Establece un registro para la tabla computador
                        $computer = new Computer();
                        // Asigna el serial al registro creado
                        $computer->SerialNumber = str_replace(" ", "", $computer_data['Serial']);
                        // Asigna el hostname al registro creado
                        $computer->HostName = str_replace(" ", "", $computer_data['Workstation']);
                        // Asigna el sistema operativo al registro creado
                        $computer->OS = $computer_data['OS'];
                        // Asigna la marca al regirstro creado
                        $computer->Brand = $computer_data['Brand'];
                        // Asigna el modelo al registro creado
                        $computer->Model = $computer_data['Model'];
                        // Valida si el computador debe ser una laptop
                        if ($computer_data['isLaptop'] == "YES") {
                            // Asigna el computador como una laptop
                            $computer->Laptop = true;
                        } else {
                            // Asigna el computador como no laptop
                            $computer->Laptop = false;
                        }

                        // Valida que si hay un computador con ese serial y que se haya suministrado un serial en el archivo
                        if (sizeof($resultComputer) != 0 || $computer_data['Serial'] == "") {
                            // Activa la varible que indica que hay computadores ya registrados
                            $registered = true;
                            // Aumenta la variables de computadores ya registrados en 1
                            $count_fails++;
                            // Agrega el computador ya registrado a la lista
                            $fails .= $computer_data['Serial'] . ' - ' . $computer_data['Workstation'] . '; ';
                        } else {
                            // Aumenta la variable que dice el numero de registros nuevos en 1
                            $count++;
                            // Guarda el nuevo computador en la db
                            $computer->save();
                        }
                    }
                    // Valida si la variable de computadores ya registrados está activada
                    if ($registered) {
                        // Convierte en un array la información de computadores que ya estaban registrados
                        $mes = explode(":", $fails);
                        // Retorna un mensaje diciendo el numero de computadores que se registraron y la información de computadores que ya estaban registrados
                        return back()->with(['message' => $count . ' computers successfully registered. ', 'th' => $fails, 'alert' => 'warning', 'mes' => $mes, 'fails' => $count_fails]);
                    }
                    // Retorna un mensaje successful indicando la cantidad de computadores nuevos registrados
                    return back()->with(['message' => $count . ' computers successfully registered. ', 'alert' => 'success']);
                } else {
                    // Retorna un mensaje indicando que hay un posible ataque de subida de archivos
                    return "¡Possible file upload attack!\n";
                }

                // Retorna la vista de registro de computadores
                return view('register_computer');
            }
        } catch (\Throwable $th) {
            // Si en algun momento se encontró algun error imprevisto, devuelve un mensaje de error con una descripción.
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
        $computer->SerialNumber = str_replace(" ", "", request('serial'));
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

    /**
     * Método para listar todos los computadores y hacer alguna busqueda
     */
    public function computersList()
    {
        // Declara la variable con la información que se quiere filtrar
        $text = trim(request('text'));
        // Valida que se quiera hacer algun filtro
        if ($text != null) {
            // Busca los computadores que tenga información relacionada a la busqueda en el campo del serial
            $computers = Computer::where('SerialNumber', 'LIKE', '%' . $text . '%')->get();
            // Verifica si se encontró alguna informació al respecto
            if ($computers->isEmpty()) {
                // Busca los computadores que tenga información relacionada a la busqueda en el campo de hostname
                $computers = Computer::where('HostName', 'LIKE', '%' . $text . '%')->get();
            }
            // Verifica si se encontró alguna informació al respecto
            if ($computers->isEmpty()) {
                // Busca los computadores que tenga información relacionada a la busqueda en el campo de Status
                $computers = Computer::where('Status', 'LIKE', '%' . $text . '%')->get();
            }
            // Retorna la vista computers con los computadores encontrados
            return view('computers', compact('computers'));
        }
        // Busca todos los computadores
        $computers = DB::table('computers')->latest()->offset(2000)->limit(1000)->get();
        // Retorna la vista computers con los computadores encontrados
        return view('computers', compact('computers'));
    }


    /**
     * Método para actualizar la información de un computador
     */
    public function computersUpdate()
    {
        try {
            // Valida si debe guardarse como una laptop o no.
            $laptop = request('laptop') == 'on' ? true : false;

            $computer = Computer::where('SerialNumber', request('serial'))->first();

            $computer->HostName = request('host');
            $computer->OS = request('host');
            $computer->Brand = request('brand');
            $computer->Model = request('model');
            $computer->Laptop = $laptop;
            $computer->save();
            switch (request('status')) {
                case 'InStorage':
                    $is_deployed = WaveEmployee::where('SerialNumberComputer', $computer->SerialNumber)->where('attrition', 0)->first();
                    if ($is_deployed) {
                        return back()->with(['message' => 'The status selected did not change because the computer is deployed in a wave', 'alert' => 'warning']);
                    }
                    $computer->Status = "InStorage";
                    $computer->save();
                    break;
                case 'Deployed':
                    # code...
                    break;
                case 'Damaged':
                    # code...
                    break;

                default:
                    return back()->with(['message' => 'The status selected is not valid', 'alert' => 'warning']);
                    break;
            }
            // Retorna un mensaje successful
            return back()->with(['message' => 'Updated', 'alert' => 'success']);
        } catch (\Throwable $th) {
            // Si en algun momento se encontró algun error imprevisto, devuelve un mensaje de error con una descripción.
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }

    /**
     * Método para mostrar información relacionada con un computador
     */
    public function computerTracert($SerialNumber)
    {
        // Busca el computador en cuestión
        $computer = Computer::where('SerialNumber', $SerialNumber)->first();
        // Busca la información wave del computador
        $waves_computer = WaveEmployee::where('SerialNumberComputer', $SerialNumber)->latest()->get();
        // Retorna la vista computer_tracert con la información encontrada
        return view('computer_tracert', compact('computer', 'waves_computer'));
    }

    /**
     * Método para establecer el estado de un computador en blacklist
     */
    public function inBlackList($SerialNumber)
    {
        try {
            // Busca el computador en cuestión
            $computer =  DB::table('computers')->where('SerialNumber', $SerialNumber)->get();
            // Valida que el comptuador no esté en un estado de BlackList
            if ($computer[0]->Status != 'InBlackList') {
                // Actualiza el estado del computador a BlackList
                DB::table('computers')->where('SerialNumber', $SerialNumber)
                    ->update(['Status' => 'InBlackList']);
                // Retorna un mensaje successful
                return back()->with(['message' => 'Updated', 'alert' => 'success']);
            } else {
                // Actualiza el estado del computador a InStorage
                DB::table('computers')->where('SerialNumber', $SerialNumber)
                    ->update(['Status' => 'InStorage']);
                // Retorna un mensaje successful
                return back()->with(['message' => 'Updated', 'alert' => 'success']);
            }
        } catch (\Throwable $th) {
            // Si en algun momento se encontró algun error imprevisto, devuelve un mensaje de error con una descripción.
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }
}
