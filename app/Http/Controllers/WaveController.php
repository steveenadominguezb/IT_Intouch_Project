<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\User;
use App\Models\Wave;
use Illuminate\Http\Request;

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
    public function store(Request $request){

        // $this->validate($request, [
        //     'floatingName' => 'required',
        //     'floatingDate' => 'required',
        //     'floatingInspector' => 'required',
        // ]);

        $wave = new Wave();
        $wave->Name = request('floatingName');
        $wave->StartDate = request('floatingDate');
        $wave->ItopsInspector = request('floatingInspector');
        $wave->IdProgram = request('floatingSelect');

        $wave->save();

        return back();
    }

    public function create($IdWave){
        $wave = Wave::where('IdWave', $IdWave)->first();
        if($wave){
            return view('wave', compact('wave'));
        }
       return "wave doesn't exist";
    }

    public function showComputers($IdWave){
        $computers = Computer::all();
        $wave = Wave::where('IdWave', $IdWave)->first();
        if($wave){
            return view('assign_computers', compact('wave', 'computers'));
        }
       return "wave doesn't exist";
    }

    public function showUsers($IdWave){
        $users = User::all();
        $wave = Wave::where('IdWave', $IdWave)->first();
        if($wave){
            return view('assign_users', compact('wave','users'));
        }
       return "wave doesn't exist";
    }
}
