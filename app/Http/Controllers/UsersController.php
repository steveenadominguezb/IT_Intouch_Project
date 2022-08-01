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
        $this->middleware('auth');
    }
    /**
     * Show the view
     */
    public function index()
    {
        $text = trim(request('text'));
        if ($text != null) {
            $users = User::where('cde', 'LIKE', '%' . $text . '%')->get();
            if ($users->isEmpty()) {
                $users = User::where('name', 'LIKE', '%' . $text . '%')->get();
            }
            if ($users->isEmpty()) {
                $users = User::where('Status', 'LIKE', '%' . $text . '%')->get();
            }
            if ($users->isEmpty()) {
                $users = User::where('position', 'LIKE', '%' . $text . '%')->get();
            }
            return view('users', compact('users'));
        }

        $users = User::all();
        return view('users', compact('users'));
    }

    /**
     * User Tracert
     */
    public function userTracert($cde)
    {
        $user = User::where("cde", $cde)->first();
        $waves_user = WaveEmployee::where('cde', $cde)
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
                ]);
            return back()->with(['message' => 'Updated', 'alert' => 'success']);
        } catch (\Throwable $th) {
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }
}
