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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create()
    {
        $this->validate(request(), [
            'cde' => 'required',
            'name' => 'required',
            'position' => 'required',
            'UserName' => 'required',
            'Password' => 'required|confirmed',
            'email' => 'required|email',
            'number' => 'required',


        ]);
        // $employee = new employee();
        // $employee->CDE = request('cde');
        // $employee->Name = request('name');
        // $employee->Position = request('position');
        // $employee->UserName = request('UserName');

        // if (request('Password') == "") {
        //     $employee->Password = null;
        // } else {
        //     $employee->Password = request('Password');
        // }

        // $employee->Email = request('email');
        // $employee->ContactInfo = request('number');
        // $employee->Status = 'Active';
        // #$employee->Admin = true;

        // $employee->setPassword(request('Password'));
        // $employee->IdPrivilege = request('SelectPrivileges');

        // $employee->save();

        #auth()->login($employee);
        return back();
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
    }
}
