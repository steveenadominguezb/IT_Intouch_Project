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
        $this->middleware('admin');
        $this->middleware('auth');
    }
    /**
     * Show the view
     */
    public function index()
    {
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
            // Comprueba que si se subió algun archivo y el tipo de archivo
            if ($_FILES['file']['size'] > 0 && $_FILES['file']['type'] == 'text/csv') {
                // Declara una variable fails que indica los usuarios que ya están registrados
                $fails = 'This Users is already registered: ';
                // Declara una variable para llevar la cuenta de los usuarios ya registrados
                $count_fails = 0;
                // Declara una variable que indica que se encontraron usuarios ya registrados
                $registered = false;
                // Declara una variable para saber cuantos usuarios nuevos se van a registrar
                $count = 0;
                // Se establece el directorio de subida del archivo entrante
                $dir_subida = 'files/users/';
                // Se establece el directorio completo de la ubicacion del archivo
                $fichero_subido = $dir_subida . basename($_FILES['file']['name']);
                // Se valida y mueve el archivo subido al directorio suministrado
                if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {

                    // Se mapea el archivo, leyendolo y almacenandolo en una variable tipo array
                    $csv = array_map('str_getcsv', file('files/users/' . $_FILES['file']['name']));
                    array_walk($csv, function (&$a) use ($csv) {
                        $a = array_combine($csv[0], $a);
                    });
                    array_shift($csv);

                    // Se recorre el array con la información del archivo
                    foreach ($csv as $employee) {

                        // Establece un registro para la tabla user
                        $user = new User();
                        // Asigna el codigo al registro creado
                        $user->cde = $employee['cde'];
                        // Asigna el name al registro creado
                        $user->name = $employee['name'];
                        // Asigna la position al registro creado
                        $user->position = $employee['position'];
                        // Numero extra para los usuarios repetidos
                        $num = 1;
                        // Valida si se le ingresó un username
                        if ($employee['username'] == "") {
                            // Separa el nombre en un array
                            $split = explode(' ', $employee['name']);

                            // Valida si el tamaño del array es 2 0 3 (nombres con solo primer nombre y dos apellidos o primer nombre y un apellido)
                            if (sizeof($split) == 3 || sizeof($split) == 2) {
                                // Establece el username con la concatenación del primer nombre y primer apellido
                                $user->username = strtolower($split[0]) . "." . strtolower($split[1]);
                                // Establece el email con la concatenación del primer nombre y primer apellido
                                $user->email = strtolower($split[0]) . "." . strtolower($split[1]) . "@24-7intouch.com";
                            } else {
                                // Establece el username con la concatenación del primer nombre y primer apellido
                                $user->username = strtolower($split[0]) . "." . strtolower($split[2]);
                                // Establece el email con la concatenación del primer nombre y primer apellido
                                $user->email = strtolower($split[0]) . "." . strtolower($split[2]) . "@24-7intouch.com";
                            }

                            $ver_user = User::where('username', $user->username)->first();
                            while ($ver_user) {
                                $user->username = "xx".$user->username . $num;
                                $user->email =  "xx".$user->username . "@24-7intouch.com";
                                $ver_user = User::where('username', $user->username)->first();
                                $num++;
                            }
                        } else {
                            // Establece el username con el dato suministrado
                            $user->username = $employee['username'];
                            // Establece el email con el username suministrado
                            $user->email = $employee['username'] . "@24-7intouch.com";

                            $ver_user = User::where('username', $user->username)->first();
                            if ($ver_user) {
                                while ($ver_user) {
                                    // Establece el username con el dato suministrado
                                    $user->username = $user->username . $num;
                                    // Establece el email con el username suministrado
                                    $user->email =  $user->username . "@24-7intouch.com";
                                    $ver_user = User::where('username', $user->username)->first();
                                    $num++;
                                }
                            }
                        }
                        // Asigna el numero de contacto al registro
                        $user->ContactInfo = $employee['ContactInfo'];
                        // Valida la position suministrada
                        switch ($employee['position']) {
                            case 'Agent':
                                // Establece los permisos para agent
                                $user->privilege = 40001;
                                break;
                            case 'TL':
                                // Establece los permisos para TL
                                $user->privilege = 40001;
                                break;
                            case 'QA':
                                // Establece los permisos para QA
                                $user->privilege = 40001;
                                break;
                            case 'OM':
                                // Establece los permisos para OM
                                $user->privilege = 40001;
                                break;
                            case 'Trainer':
                                // Establece los permisos para Trainer
                                $user->privilege = 40001;
                                break;
                            case 'IT Intern':
                                // Establece los permisos para It Intern
                                $user->privilege = 30001;
                                break;
                            case 'IT Generalist':
                                // Establece los permisos para IT Generalist
                                $user->privilege = 10001;
                                break;
                            default:
                                // Establece los permisos por defecto
                                $user->privilege = 40001;
                                break;
                        }
                        // Valida si el cargo es diferente a agent
                        if ($employee['position'] != 'Agent') {
                            // Busca la wave staff de la campaña
                            $wave = Wave::where('Name', $employee['program'] . ' Staff')->first();
                            if (!$wave) {
                                // Retorna un mensaje diciendo que no hay una wave con ese nombre
                                return back()->with(['message' => 'Error, wave (' . $employee['program'] . ') Staff doesn\'t exist ', 'alert' => 'warning']);
                            }
                        } else {
                            // Busca la wave suministrada
                            $wave = Wave::where('Name', $employee['wave'])->first();
                            // Valida si existe alguna wave con esos datos
                            if (!$wave) {
                                // Retorna un mensaje diciendo que no hay una wave con ese nombre
                                return back()->with(['message' => 'Error, wave (' . $employee['wave'] . ') doesn\'t exist ', 'alert' => 'warning']);
                            }
                        }

                        // Declara una variable para saber si existe la location suministrada
                        $created = false;
                        // Establece un idlocation
                        $idLocation = 0;
                        // Recorre cada location que tenga una la wave encontrada
                        foreach ($wave->locations as $location) {
                            // Quita las tildes de las letras (á,í), pone en minisculas y valida si es igual a la location suministrada 
                            if (strtolower(str_replace(['á', 'í'], ['a', 'i'], $location->location['Name'])) == strtolower($employee['location'],)) {
                                // Actualiza la variable que nos dice si la location ya está creada
                                $created = true;
                                // Actualiza el valor del idLocation
                                $idLocation = $location['IdWaveLocation'];
                            }
                        }
                        // Valida si la location no está creada
                        if (!$created) {
                            //Retorna un mensaje diciendo que la location no está creada en la wave
                            return back()->with(['message' => 'Error, wave (' . $employee['wave'] . ') doesn\'t have a ' . strtolower($employee['location']) . ' location', 'alert' => 'warning']);
                        }

                        if ($employee['cde'] == "") {
                            $result = DB::table('users')->where('name', $employee['name'])->get();
                        } else {

                            // Busca usuarios que tenga el codigo leído
                            $result = DB::table('users')->where('cde', $employee['cde'])->get();
                        }
                        // Valida que haya algun registro con el codigo suministrado y si se suministró dicho codigo
                        if (sizeof($result) != 0) {
                            $user = $result->first();
                            // Actualiza la variable que indica que el usuario ya está registrado
                            $registered = true;
                            // Aumenta el valor de la variable que indica el numero de usuarios registrados
                            $count_fails++;
                            // Añade el usuario a la lista de registrados
                            $fails .= $employee['cde'] . ' - ' . $employee['name'] . '; ';
                        } else {

                            //Aumenta el valor de la variable de los usuarios que se van a registrar
                            $count++;
                            // Registra el usuario creado
                            $user->save();

                            if ($employee['cde'] == "") {
                                $recent_user = User::where('Name', $user->name)->first();
                                $user->cde = $recent_user->id;
                                $user->save();
                            }
                        }



                        // Establece un registro para la tabla waveemployees
                        $wave_employees = new WaveEmployee();
                        // Asigna el codigo del empleado al registro
                        $wave_employees->cde = $user->cde;
                        // Asigna la location al registro
                        $wave_employees->IdWave = $idLocation;
                        // Asigna la date
                        $wave_employees->Date = $employee['date'];
                        // Busca un registro que tenga ya el codigo de usuario suministrado
                        $result_wave = DB::table('wave_employees')->where('cde', $user->cde)->get();

                        // Valida si no encontró algun registro
                        if (sizeof($result_wave) == 0 && sizeof($result) == 0) {
                            // Guarda el nuevo registro en la db
                            $wave_employees->save();
                            // Actualiza el estado del usuairo a ActiveFull
                            $user->status = "ActiveFull";
                            $user->save();
                        }
                    }

                    // Valida si hubieron usuarios ya registrados
                    if ($registered) {
                        // Convierte en un array la información de usuarios que ya estaban registrados
                        $mes = explode(":", $fails);
                        // Retorna un mensaje diciendo el numero de usuarios que se registraron y la información de usuarios que ya estaban registrados
                        return back()->with(['message' => $count . ' users successfully registered. ', 'th' => $fails, 'alert' => 'warning', 'mes' => $mes, 'fails' => $count_fails]);
                    }
                    // Retorna un mensaje successful indicando la cantidad de usuarios nuevos registrados
                    return back()->with(['message' => $count . ' users successfully registered.', 'alert' => 'success']);
                } else {
                    // Retorna un mensaje indicando que hay un posible ataque de subida de archivos
                    return "¡Possible file upload attack!\n";
                }
                // Retorna la vista de registro de computadores
                return view('register_employee');
            }
        } catch (\Throwable $th) {
            // Si en algun momento se encontró algun error imprevisto, devuelve un mensaje de error con una descripción.
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
