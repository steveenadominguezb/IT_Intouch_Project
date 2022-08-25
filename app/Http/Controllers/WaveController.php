<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Computer;
use App\Models\User;
use App\Models\Wave;
use App\Models\WaveEmployee;
use App\Models\WaveLocation;
use App\Models\Yubikey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\returnValueMap;

class WaveController extends Controller
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
     * Método para insertar una wave nueva a la db
     */
    public function store(Request $request)
    {

        // $this->validate($request, [
        //     'floatingName' => 'required',
        //     'floatingDate' => 'required',
        //     'floatingInspector' => 'required',
        // ]);

        // Crea una instancia wave 
        $wave = new Wave();
        // Asigna el nombre de la wave
        $wave->Name = request('floatingName');
        // Asigna la fecha de la wave
        $wave->StartDate = request('floatingDate');
        // Asigna la persona responsable de la wave
        $wave->ItopsInspector = request('floatingInspector');
        // Asigna el programa de la wave
        $wave->IdProgram = request('floatingSelect');
        // Guarda la wave en la db
        $wave->save();

        // Busca la wave recientemente creada
        $wave = Wave::where('Name', request('floatingName'))->orderByDesc('created_at')->first();

        // Recorre el array de locations para insertar una por una en la wave
        foreach (request('locations') as $location) {

            // Crea una instancia wavelocation
            $wave_location = new WaveLocation();
            // Establece la wave a la que pertenece
            $wave_location->IdWave = $wave->IdWave;
            // Establece la location a la que pertenece
            $wave_location->IdLocation = $location;
            // Guarda la instancia en la db
            $wave_location->save();
        }
        // Regresa a la vista home
        return back();
    }

    /**
     * Método para mostrar la información de la wave junto con sus locations, computers y users asignados.
     */
    public function create($IdWave, $location)
    {
        $wave_parent = Wave::where('IdWave', $IdWave)->first();
        if (!$wave_parent) {
            abort(404);
        }
        // Busca la wave que corresponda al IdWave y IdLocation dado en la url
        $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();

        // Establece una variable que va ayudar a buscar la información de las otras locations
        $i = 101;
        // Verifica si no existe una wave con la información dada, hasta que no existe una location de esa wave no sale del bucle
        while (!$wave) {
            // Busca una nueva wave con el IdLocation correspondiente a $i
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $i)->first();
            // Incrementa el IdLocation para validar la si existe un registro con la siguiente location
            $i += 100;
        }
        $wave_employee = WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('attrition', 0)->get();
        $count_registers = (sizeof($wave_employee) == 0) ? 1 : sizeof($wave_employee);
        $count_progress = sizeof(WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('cde', '!=', null)->where('SerialNumberComputer', '!=', null)->where('attrition', 0)->get());
        $progress = ($count_progress / $count_registers) * 100;
        // Busca los computadores asignados a esa wave y location
        $computers_view = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('attrition', '==', '0')
            ->join('computers', 'wave_employees.SerialNumberComputer', '=', 'computers.SerialNumber')
            ->leftJoin('users', 'wave_employees.cde', '=', 'users.cde')
            ->get();
        // Busca los usuarios asignados a esa wave y location
        $users_view = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('attrition', '==', '0')
            ->join('users', 'wave_employees.cde', '=', 'users.cde')
            ->get();

        // Verifica si existe la wave correspondiente
        if ($wave) {
            // Busca todas los locations relacionadas a esa wave
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            // Valida si la location dada en la url no es igual a la location de la wave
            if ($location != $wave->location->IdLocation) {
                // Redirige a la vista de la wave con un valor valido de una location de la wave
                return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $wave->location->IdLocation . '')->with(['wave' => $wave, 'locations' => $locations, 'progress' => $progress]);
            }
            // Dirige a la vista de la wave con toda la información encontrada
            return view('wave_home', compact('wave', 'locations', 'computers_view', 'users_view', 'progress'));
        }
        // Retorna un mensaje diciendo que la wave no existe
        return "wave doesn't exist";
    }

    /**
     * Método para borrar una wave
     */
    public function delete()
    {
        try {
            $IdWave = request('IdWave');
            $wave = Wave::where('IdWave', $IdWave)->delete();

            return back();
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }

    /**
     * 
     */
    public function showComputers($IdWave, $location)
    {
        $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
        $wave_employee = WaveEmployee::where('IdWave', $wave->IdWaveLocation)->get();
        $count_registers = (sizeof($wave_employee) == 0) ? 1 : sizeof($wave_employee);
        $count_progress = sizeof(WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('cde', '!=', null)->where('SerialNumberComputer', '!=', null)->get());
        $progress = ($count_progress / $count_registers) * 100;
        $locations = WaveLocation::where('IdWave', $IdWave)->get();
        $text = trim(request('text'));
        if ($text != null) {
            $computers = Computer::where('SerialNumber', 'LIKE', '%' . $text . '%')->where('Status', 'InStorage')->orderByDesc('created_at')->get();
            if ($computers->isEmpty()) {
                $computers = Computer::where('HostName', 'LIKE', '%' . $text . '%')->where('Status', 'InStorage')->orderByDesc('created_at')->get();
            }
            return view('assign_computers', compact('wave', 'locations', 'computers', 'progress'));
        }

        $computers = Computer::where('Status', 'InStorage')->orderByDesc('created_at')->get();
        if ($wave) {
            return view('assign_computers', compact('wave', 'computers', 'locations', 'progress'));
        }
        return "wave doesn't exist";
    }

    public function showUsers($IdWave, $location)
    {
        $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
        $wave_employee = WaveEmployee::where('IdWave', $wave->IdWaveLocation)->get();
        $count_registers = (sizeof($wave_employee) == 0) ? 1 : sizeof($wave_employee);
        $count_progress = sizeof(WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('cde', '!=', null)->where('SerialNumberComputer', '!=', null)->get());
        $progress = ($count_progress / $count_registers) * 100;
        $locations = WaveLocation::where('IdWave', $IdWave)->get();
        $text = trim(request('text'));
        if ($text != null) {
            $users = User::where('cde', 'LIKE', '%' . $text . '%')->where('status', 'Active')
                ->where('privilege', 40001)
                ->get();
            if ($users->isEmpty()) {
                $users = User::where('name', 'LIKE', '%' . $text . '%')->where('status', 'Active')
                    ->where('privilege', 40001)
                    ->get();
            }
            if ($users->isEmpty()) {
                $users = User::where('username', 'LIKE', '%' . $text . '%')->where('status', 'Active')
                    ->where('privilege', 40001)
                    ->get();
            }
            return view('assign_users', compact('wave', 'users', 'locations', 'progress'));
        }

        if ($wave->parent->Name == 'Staff') {
            $users = User::where('privilege', '!=', '40001')->where('status', '!=', 'ActiveFull')->get();
            return view('assign_users', compact('wave', 'users', 'locations', 'progress'));
        }
        $users = User::where('status', 'Active')->where('Position', 'Agent')
            ->orWhere('Position', 'TL')
            ->orWhere('Position', 'OM')
            ->orWhere('Position', 'QA')->get();
        if ($wave) {
            return view('assign_users', compact('wave', 'users', 'locations', 'progress'));
        }
        return "wave doesn't exist";
    }

    public function assignComputers($IdWave, $location)
    {
        if (request('file')) {
            try {
                $locations = WaveLocation::where('IdWave', $IdWave)->get();
                $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
                $wave_employee = WaveEmployee::where('IdWave', $wave->IdWaveLocation)->get();
                $count_registers = (sizeof($wave_employee) == 0) ? 1 : sizeof($wave_employee);
                $count_progress = sizeof(WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('cde', '!=', null)->where('SerialNumberComputer', '!=', null)->get());
                $progress = ($count_progress / $count_registers) * 100;
                $assigned = "";
                $no_registered = "";
                if ($_FILES['file']['size'] > 0 && $_FILES['file']['type'] == 'text/csv') {
                    $dir_subida = 'files/users/';
                    $fichero_subido = $dir_subida . basename($_FILES['file']['name']);
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {

                        $csv = array_map('str_getcsv', file('files/users/' . $_FILES['file']['name']));
                        array_walk($csv, function (&$a) use ($csv) {
                            $a = array_combine($csv[0], $a);
                        });
                        array_shift($csv);

                        foreach ($csv as $computer) {
                            $computer['Serial'] = str_replace(" ", "", $computer['Serial']);

                            $result = Computer::where('SerialNumber', str_replace(" ", "", $computer['Serial']))->get();
                            if (sizeof($result) == 0) {
                                $no_registered .= 'Error, ' . $computer['Serial'] . ' is not registered;';
                            } else {
                                if ($result[0]->Status != "InStorage") {
                                    $assigned .= 'Error, ' . $result[0]->HostName . ' is already assigned or does not correspond to the wave; ';
                                } else {
                                    $update_wave_employee = WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $computer['Serial'])->first();
                                    if (!$update_wave_employee) {
                                        $update_wave_employee = new WaveEmployee();
                                    }
                                    $update_wave_employee->SerialNumberComputer = $computer['Serial'];
                                    $update_wave_employee->IdWave = $wave->IdWaveLocation;
                                    $update_wave_employee->save();

                                    $computer = Computer::where('SerialNumber', $computer['Serial'])->first();
                                    $computer->Status = "Deployed";
                                    $computer->save();
                                }
                            }
                        }
                    } else {
                        return "¡Possible file upload attack!\n";
                    }
                }
                if ($assigned != "" || $no_registered != "") {
                    return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error', 'th' => $assigned . "--" . $no_registered, 'alert' => 'warning', 'locations' => $locations, 'progress' => $progress]);
                }
                return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'wave' => $wave, 'locations' => $locations, 'progress' => $progress]);
            } catch (\Throwable $th) {
                return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'wave' => $wave, 'locations' => $locations, 'progress' => $progress]);
            }
        }

        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
            $wave_employee = WaveEmployee::where('IdWave', $wave->IdWaveLocation)->get();
            $count_registers = (sizeof($wave_employee) == 0) ? 1 : sizeof($wave_employee);
            $count_progress = sizeof(WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('cde', '!=', null)->where('SerialNumberComputer', '!=', null)->get());
            $progress = ($count_progress / $count_registers) * 100;
            if (is_null(request('assign'))) {
                return back()->with(['message' => 'Nothing selected', 'alert' => 'success', 'locations' => $locations]);
            }
            foreach (request('assign') as $value) {

                $wave_employee = WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $value)->first();

                if (!$wave_employee) {
                    $wave_employee = new WaveEmployee();
                }

                $wave_employee->SerialNumberComputer = $value;
                $wave_employee->IdWave = $wave->IdWaveLocation;
                $wave_employee->save();

                $computer = Computer::where('SerialNumber', $value)->first();
                $computer->Status = "Deployed";
                $computer->save();
            }
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'wave' => $wave, 'locations' => $locations, 'progress' => $progress]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'wave' => $wave, 'locations' => $locations, 'progress' => $progress]);
        }
    }

    public function assignUsers($IdWave, $location)
    {
        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
            $wave_employee = WaveEmployee::where('IdWave', $wave->IdWaveLocation)->get();
            $count_registers = (sizeof($wave_employee) == 0) ? 1 : sizeof($wave_employee);
            $count_progress = sizeof(WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('cde', '!=', null)->where('SerialNumberComputer', '!=', null)->get());
            $progress = ($count_progress / $count_registers) * 100;
            if (is_null(request('assign'))) {
                return back()->with(['message' => 'Nothing selected', 'alert' => 'success', 'locations' => $locations, 'progress' => $progress]);
            }
            foreach (request('assign') as $value) {

                $wave_employee = WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('cde', $value)->first();
                if (!$wave_employee) {
                    $wave_employee = new WaveEmployee();
                }

                $wave_employee->cde = $value;
                $wave_employee->Date = now();
                $wave_employee->IdWave = $wave->IdWaveLocation;
                $wave_employee->save();


                $user = User::where('cde', $value)->first();
                $user->status = "ActiveFull";
                $user->save();
            }

            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'wave' => $wave, 'locations' => $locations, 'progress' => $progress]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'locations' => $locations, 'progress' => $progress]);
        }
    }

    public function unassignComputer($IdWave, $location, $SerialNumber)
    {
        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
            $wave_employees = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->first();

            if ($wave_employees->cde != null) {
                DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->update(['SerialNumberComputer' => null]);
            } else {
                DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->delete();
            }

            DB::table('computers')->where('SerialNumber', $SerialNumber)->update(['Status' => 'InStorage']);

            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'locations' => $locations]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'locations' => $locations]);
        }
    }

    public function unassignUser($IdWave, $location, $cde)
    {
        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();

            $wave_employees = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('cde', $cde)->first();

            if ($wave_employees->SerialNumberComputer != null) {
                DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('cde', $cde)->update(['cde' => null]);
            } else {
                DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('cde', $cde)->delete();
            }

            DB::table('users')->where('cde', $cde)->update(['status' => 'Active']);

            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'locations' => $locations]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'locations' => $locations]);
        }
    }

    public function assignComputerUser($IdWave, $location, $SerialNumber)
    {
        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();

            $celdas = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', null)
                ->where('cde', request('UserCode'))
                ->get();

            if (sizeof($celdas) == 1) {

                $wave_employees = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->first();

                if ($wave_employees->cde != null) {
                    DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->update(['SerialNumberComputer' => null]);
                } else {
                    DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->delete();
                }

                DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', null)
                    ->where('cde', request('UserCode'))
                    ->update(['SerialNumberComputer' => $SerialNumber, 'SerialNumberKey' => request('yubikey')]);
            } else {

                return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, user is already assigned or does not correspond to the wave', 'alert' => 'danger', 'locations' => $locations]);
            }
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'locations' => $locations]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'locations' => $locations]);
        }
    }

    public function updateStatus($cde)
    {
        DB::table('users')->where('cde', $cde)->update(['status' => 'Active']);
    }

    public function addLocation($IdWave, $location)
    {
        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();

            $wave_location = new WaveLocation();
            $wave_location->IdWave = $IdWave;
            $wave_location->IdLocation = request('floatingSelectLocation');
            $wave_location->save();

            return redirect()->to('/home/wave/' . $IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'locations' => $locations]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'locations' => $locations]);
        }
    }

    public function inventory($IdWave, $location)
    {

        $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
        $locations = WaveLocation::where('IdWave', $IdWave)->get();
        $inventory = Component::all();
        return view('wave_inventory', compact('wave', 'locations', 'inventory'));
    }

    public function relateEverything($IdWave, $location)
    {
        $locations = WaveLocation::where('IdWave', $IdWave)->get();
        $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
        $computers_registered = 'These Computers is not registered: ';
        $count_computers = 0;
        $users_registered = 'These Users is not registered: ';
        $count_users_registered = 0;
        $registered_users = false;
        $users_assigned = 'These Users are already assigned or do not correspond to the wave or location: ';
        $count_users = 0;
        $assigned = false;
        $registered = false;
        $count = 0;
        $no_yubikey = "";
        $no_computer = "";
        if (request('file')) {
            try {
                if ($_FILES['file']['size'] > 0 && $_FILES['file']['type'] == 'text/csv') {
                    $dir_subida = 'files/users/';
                    $fichero_subido = $dir_subida . basename($_FILES['file']['name']);
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {

                        $csv = array_map('str_getcsv', file('files/users/' . $_FILES['file']['name']));
                        array_walk($csv, function (&$a) use ($csv) {
                            $a = array_combine($csv[0], $a);
                        });
                        array_shift($csv);

                        foreach ($csv as $computer) {
                            try {
                                $jump = true;
                                if (!isset($computer['YubiKey'])) {
                                    $jump = false;
                                    $computer['YubiKey'] = null;
                                }

                                if ($computer['YubiKey'] == "" && $jump) {
                                    $no_yubikey .= 'No YubiKey in This Relationship [' . $computer['Workstation'] . '] - [' . $computer['Username'] . ']; ';
                                } else {

                                    $yubikey = Yubikey::where('SerialNumber', $computer['YubiKey'])->first();

                                    if (!$yubikey && $jump) {
                                        $no_yubikey .= 'This yubikey [' . $computer['YubiKey'] . '] is not registered; ';
                                    } else {
                                        if ($computer['Serial'] != "") {
                                            $resultUser = DB::table('users')->where('name', $computer['Username'])->get();
                                            $resultComputer = DB::table('computers')->where('SerialNumber', $computer['Serial'])->get();
                                            if (sizeof($resultComputer) == 0) {
                                                $registered = true;
                                                $count_computers++;
                                                $computers_registered .= $computer['Serial'] . ' - ' . $computer['Workstation'] . '; ';
                                            }

                                            if (sizeof($resultUser) == 0) {
                                                $registered_users = true;
                                                $count_users_registered++;
                                                $users_registered .= $computer['Username'] . '; ';
                                                continue;
                                            }
                                            $celdas = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', null)
                                                ->where('cde', $resultUser[0]->cde)
                                                ->get();
                                            if (sizeof($celdas) == 1) {

                                                $wave_employees = WaveEmployee::where('IdWave', $wave->IdWaveLocation)
                                                    ->where('SerialNumberComputer', $computer['Serial'])->first();

                                                if ($wave_employees) {
                                                    if ($wave_employees->cde != null) {
                                                        $wave_employees->SerialNumberComputer = null;
                                                        $wave_employees->save();
                                                    } else {
                                                        DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $computer['Serial'])->delete();
                                                    }
                                                    $wave_employee_1 = WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', null)
                                                        ->where('cde', $resultUser[0]->cde)->first();

                                                    $wave_employee_1->SerialNumberComputer = $computer['Serial'];

                                                    $wave_employee_1->SerialNumberKey = $computer['YubiKey'];

                                                    $wave_employee_1->save();

                                                    $count++;
                                                } else {
                                                    $no_computer .= 'This Computer [' . $computer['Workstation'] . '] is not assigned; ';
                                                }
                                            } elseif (sizeof($celdas) == 0 && sizeof($resultUser) > 0) {
                                                $assigned = true;
                                                $count_users++;
                                                $users_assigned .= $resultUser[0]->cde . ' - ' . $resultUser[0]->name . '; ';
                                            }
                                        }
                                    }
                                }
                            } catch (\Throwable $th) {
                                return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'wave' => $wave, 'locations' => $locations]);
                            }
                        }
                        if ($registered_users) {
                            $mes = explode(":", $users_registered);
                            return back()->with(['message' => $count . ' computers successfully assigned. ', 'th' => $users_registered, 'alert' => 'warning', 'mes' => $mes, 'fails' => $count_users_registered]);
                        }
                        if ($assigned) {
                            $mes = explode(":", $users_assigned);
                            return back()->with(['message' => $count . ' computers successfully assigned. ', 'th' => $users_assigned, 'alert' => 'warning', 'mes' => $mes, 'fails' => $count_users]);
                        }
                        if ($registered) {
                            $mes = explode(":", $computers_registered);
                            return back()->with(['message' => $count . ' computers successfully assigned. ', 'th' => $computers_registered, 'alert' => 'warning', 'mes' => $mes, 'fails' => $count_computers]);
                        }
                        if ($no_yubikey != "" || $no_computer != "") {
                            return back()->with(['message' => $count . ' computers successfully assigned. ', 'th' => $no_yubikey . $no_computer, 'alert' => 'warning']);
                        }
                    } else {
                        return "¡Possible file upload attack!\n";
                    }
                }
                return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'wave' => $wave, 'locations' => $locations]);
            } catch (\Throwable $th) {
                return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'wave' => $wave, 'locations' => $locations]);
            }
        }
        return back()->with(['message' => 'Nothing selected', 'alert' => 'success', 'locations' => $locations]);
    }

    public function allLocations($IdWave)
    {
        $locations = WaveLocation::where('IdWave', $IdWave)
            ->join('locations', 'wave_locations.IdLocation', '=', 'locations.IdLocation')
            ->get();
        $result = [];
        $num_locations = 0;
        $count_registers = 0;
        $count_progress = 0;
        foreach ($locations as $location) {
            array_push($result, $location);
            $computers_info = WaveEmployee::where('IdWave', $location->IdWaveLocation)->where('attrition', 0)
                ->join('computers', 'wave_employees.SerialNumberComputer', '=', 'computers.SerialNumber')
                ->get();
            $users_info = WaveEmployee::where('IdWave', $location->IdWaveLocation)->where('attrition', 0)
                ->join('users', 'wave_employees.cde', '=', 'users.cde')
                ->get();

            if (sizeof($computers_info) != 0) {
                $result[$num_locations]['Computers'] = $computers_info;
            } else {
                $result[$num_locations]['Computers'] = [];
            }
            if (sizeof($users_info) != 0) {
                $result[$num_locations]['Users'] = $users_info;
            } else {
                $result[$num_locations]['Users'] = [];
            }
            $num_locations++;

            $wave_employee = WaveEmployee::where('IdWave',  $location->IdWaveLocation)->where('attrition', 0)->get();
            $count_registers += (sizeof($wave_employee) == 0) ? 1 : sizeof($wave_employee);
            $count_progress += sizeof(WaveEmployee::where('IdWave', $location->IdWaveLocation)->where('cde', '!=', null)->where('SerialNumberComputer', '!=', null)->where('attrition', 0)->get());
        }
        $wave = WaveLocation::where('IdWave', $IdWave)->first();
        $all_locations = "All Locations";


        $progress = ($count_progress / $count_registers) * 100;
        return view('wave_all_locations', compact('wave', 'locations', 'all_locations', 'result', 'progress'));
    }

    public function progress($IdWave, $location)
    {
        $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
        $wave_employee = WaveEmployee::where('IdWave', $wave->IdWaveLocation)->get();
        $count_registers = sizeof($wave_employee) == 0 ?? 1;
        $count_progress = sizeof(WaveEmployee::where('IdWave', $wave->IdWaveLocation)->where('cde', '!=', null)->where('SerialNumberComputer', '!=', null)->get());
        return ($count_progress / $count_registers) * 100;
    }
}
