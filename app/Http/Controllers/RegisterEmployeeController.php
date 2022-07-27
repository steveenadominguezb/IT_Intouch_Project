<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Wave;
use App\Models\WaveEmployee;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class RegisterEmployeeController extends Controller
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
        return view('register_employee');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request)
    {

        try {
            if ($_FILES['file']['size'] > 0 && $_FILES['file']['type'] == 'text/csv') {
                $fails = 'This Users is already registered: ';
                $count_fails = 0;
                $registered = false;
                $count = 0;
                $dir_subida = 'files/users/';
                $fichero_subido = $dir_subida . basename($_FILES['file']['name']);
                if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {

                    // $fichero_texto = fopen('files/users/' . $_FILES['file']['name'], "r");
                    // $contenido_fichero = fread($fichero_texto, filesize('files/users/' . $_FILES['file']['name']));

                    // $text = explode("\n", $contenido_fichero);
                    $csv = array_map('str_getcsv', file('files/users/' . $_FILES['file']['name']));
                    array_walk($csv, function (&$a) use ($csv) {
                        $a = array_combine($csv[0], $a);
                    });
                    array_shift($csv);

                    foreach ($csv as $employee) {
                        $result = DB::table('users')->where('cde', $employee['cde'])->get();
                        $user = new User();
                        $user->cde = $employee['cde'];
                        $user->name = $employee['name'];
                        $user->position = $employee['position'];
                        if ($employee['username'] == "") {
                            $user->username = $employee['name'];
                            $user->email = $employee['name'] . "@24-7intouch.com";
                        } else {
                            $user->username = $employee['username'];
                            $user->email = $employee['username'] . "@24-7intouch.com";
                        }

                        $user->ContactInfo = $employee['ContactInfo'];

                        switch ($employee['position']) {
                            case 'Agent':
                                $user->privilege = 40001;
                                break;
                            case 'IT Intern':
                                $user->privilege = 30001;
                                break;
                            case 'IT Generalist':
                                $user->privilege = 10001;
                                break;
                            default:
                                $user->privilege = 20001;
                                break;
                        }

                        $wave = Wave::where('Name', $employee['wave'])->first();
                        if (!$wave) {
                            echo '<script language="javascript">alert("Error, wave (' . $employee['wave'] . ') doesn\'t exist");</script>';
                            return view('register_employee');
                        }
                        $created = false;
                        $idLocation = 0;
                        foreach ($wave->locations as $location) {
                            if (strtolower(str_replace(['á', 'í'], ['a', 'i'], $location->location['Name'])) == strtolower($employee['location'])) {
                                $created = true;
                                $idLocation = $location['IdWaveLocation'];
                            }
                        }
                        if (!$created) {
                            echo '<script language="javascript">alert("Error, wave (' . $employee['wave'] . ') doesn\'t have a ' . strtolower($employee['location']) . ' location");</script>';
                            return view('register_employee');
                        }
                        if (sizeof($result) != 0 || $employee['cde'] == "") {
                            $registered = true;
                            $count_fails++;
                            $fails .= $employee['cde'] . ' - ' . $employee['name'] . '; ';
                        } else {
                            $count++;
                            $user->save();
                        }

                        $wave_employees = new WaveEmployee();
                        $wave_employees->cde = $employee['cde'];
                        $wave_employees->IdWave = $idLocation;
                        $result = DB::table('wave_employees')->where('cde', $employee['cde'])->get();
                        if (sizeof($result) == 0) {
                            $wave_employees->save();
                            DB::table('users')->where('cde', $employee['cde'])->update(['status' => 'ActiveFull']);
                        }
                    }
                    if ($registered) {
                        $mes = explode(":", $fails);
                        return back()->with(['message' => $count . ' users successfully registered. ', 'th' => $fails, 'alert' => 'warning', 'mes' => $mes, 'fails' => $count_fails]);
                    }
                    return back()->with(['message' => 'Successfull', 'alert' => 'success']);
                } else {
                    return "¡Possible file upload attack!\n";
                }

                return view('register_employee');
            }
        } catch (\Throwable $th) {
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }


        /**
         * Valida que los campos necesarios hayan sido diligenciados
         */
        $this->validate(request(), [
            'cde' => 'required',
            'name' => 'required',
            'position' => 'required',
            'UserName' => 'required',
            'password' => 'confirmed',
            'email' => 'required|email',
            'number' => 'required',


        ]);
        /**
         * Crea un nuevo empleado
         */
        $employee = new User();
        $employee->cde = request('cde');
        $employee->name = request('name');
        $employee->position = request('position');
        $employee->username = request('UserName');

        if (request('password') == "") {
            $employee->password = Hash::make('IT!ntouch24-7@');
        } else {
            $employee->Password = Hash::make(request('password'));
        }

        $employee->email = request('email');
        $employee->ContactInfo = request('number');
        $employee->status = 'Active';
        $employee->privilege = request('SelectPrivileges');

        #Guarda el empleado
        $employee->save();

        echo '<script language="javascript">alert("successful");</script>';
        return view('register_employee');
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
    }

    public function eliminar_tildes($cadena)
    {
        //Codificamos la cadena en formato utf8 en caso de que nos de errores
        $cadena = utf8_encode($cadena);

        //Ahora reemplazamos las letras
        $cadena = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $cadena
        );

        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $cadena
        );

        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $cadena
        );

        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $cadena
        );

        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $cadena
        );

        $cadena = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $cadena
        );

        return $cadena;
    }
}
