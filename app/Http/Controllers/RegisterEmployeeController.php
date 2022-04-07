<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        return view('register_employee');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create()
    {   
        /**
         * Valida que los campos necesarios hayan sido diligenciados
         */
        $this->validate(request(), [
            'cde' => 'required',
            'name' => 'required',
            'position' => 'required',
            'UserName' => 'required',
            'password' => 'required|confirmed',
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
            $employee->password = Hash::make('!ntouch24-7@');
        } else {
            $employee->Password = Hash::make(request('password'));
        }

        $employee->email = request('email');
        $employee->ContactInfo = request('number');
        $employee->status = 'Active';
        $employee->privilege = request('SelectPrivileges');
        
        #Guarda el empleado
        $employee->save();

       
        return back();
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
    }
}
