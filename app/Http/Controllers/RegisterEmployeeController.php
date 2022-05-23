<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
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
                        $user = new User();
                        $user->cde = $employee['cde'];
                        $user->name = $employee['name'];
                        $user->position = $employee['position'];
                        $user->username = $employee['username'];
                        $user->email = $employee['email'] . "@24-7intouch.com";
                        $user->ContactInfo = $employee['ContactInfo'];
                        if ($employee['position'] != "Agent") {
                            $user->privilege = 20001;
                        } else {
                            $user->privilege = 40001;
                        }
    
    
                        $user->save();
                    }
                    echo '<script language="javascript">alert("successful");</script>';
                   
                } else {
                    return "¡Posible ataque de subida de ficheros!\n";
                }

                return view('register_employee');
            }
        } catch (\Throwable $th) {
            echo '<script language="javascript">alert("Error, try again.");</script>';
            $wait = "";
            return view('register_employee');
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
}
