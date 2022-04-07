<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if($laptop){
            $computer->Laptop = true;
        }else{
            $computer->Laptop = false;
        }
        
        $computer->Model = request('model');
        $computer->OS = request('os');
        $computer->Brand = request('brand');
        $computer->Status = request('status');

        #Guarda el computer
        $computer->save();


        return back();
    }
}
