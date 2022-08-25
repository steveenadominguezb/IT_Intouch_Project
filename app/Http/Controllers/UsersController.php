<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WaveEmployee;
use App\Models\WaveLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
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
     * Método para listar todos los usuarios o hacer alguna busqueda
     *
     */
    public function index()
    {
        // Declara la variable con la información que se quiere filtrar
        $text = trim(request('text'));
        // Valida que se quiera hacer algun filtro
        if ($text != null) {
            // Busca los usuarios que tenga información relacionada a la busqueda en el campo cde
            $users = User::where('cde', 'LIKE', '%' . $text . '%')->latest()->get();
            // Verifica si se encontró alguna informació al respecto
            if ($users->isEmpty()) {
                // Busca los usuarios que tenga información relacionada a la busqueda en el campo name
                $users = User::where('name', 'LIKE', '%' . $text . '%')->latest()->get();
            }
            // Verifica si se encontró alguna informació al respecto
            if ($users->isEmpty()) {
                // Busca los usuarios que tenga información relacionada a la busqueda en el campo status
                $users = User::where('Status', 'LIKE', '%' . $text . '%')->latest()->get();
            }
            // Verifica si se encontró alguna informació al respecto
            if ($users->isEmpty()) {
                // Busca los usuarios que tenga información relacionada a la busqueda en el campo position
                $users = User::where('position', 'LIKE', '%' . $text . '%')->latest()->get();
            }
            // Verifica si se encontró alguna informació al respecto
            if ($users->isEmpty()) {
                // Busca los usuarios que tenga información relacionada a la busqueda en el campo username
                $users = User::where('username', 'LIKE', '%' . $text . '%')->latest()->get();
            }
            // Retorna la vista users con los usuarios encontrados
            return view('users', compact('users'));
        }
        // Busca todos los usuarios
        $users = DB::table('users')->latest()->offset(2000)->limit(1000)->get();
        // Retorna la vista users con los usuarios encontrados
        return view('users', compact('users'));
    }

    /**
     * User Tracert
     * Método para dar información sobre la wave, computer y más del usuario en cuestión.
     */
    public function userTracert($cde)
    {
        $user = User::where("cde", $cde)->first();
        $waves_user = WaveEmployee::where('cde', $cde)
            ->latest()
            ->get();
        return view('user_tracert', compact('user', 'waves_user'));
    }

    /**
     * User Update
     */
    public function userUpdate()
    {
        /**
         * Valida que los campos necesarios hayan sido diligenciados
         */
        $this->validate(request(), [
            'cde' => 'required',
            'name' => 'required',
            'username' => 'required',
            'position' => 'required',
            'status' => 'required',
            'email' => 'required|email'
        ]);

        try {
            DB::table('users')->where('cde', request('cde'))
                ->update([
                    'cde' => request('cde'),
                    'name' => request('name'),
                    'username' => request('username'),
                    'position' => request('position'),
                    'email' => request('email'),
                    'status' => request('status'),
                ]);
            return back()->with(['message' => 'Updated', 'alert' => 'success']);
        } catch (\Throwable $th) {
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }
}
