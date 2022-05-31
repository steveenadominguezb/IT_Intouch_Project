<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\User;
use App\Models\Wave;
use App\Models\WaveEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

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
    public function store(Request $request)
    {

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

    public function create($IdWave)
    {
        $wave = Wave::where('IdWave', $IdWave)->first();
        $computers_view = DB::table('wave_employees')->where('IdWave', $IdWave)
            ->join('computers', 'wave_employees.SerialNumberComputer', '=', 'computers.SerialNumber')
            ->get();
        $users_view = DB::table('wave_employees')->where('IdWave', $IdWave)
            ->join('users', 'wave_employees.cde', '=', 'users.cde')
            ->get();
        if ($wave) {
            return view('wave_home', compact('wave', 'computers_view', 'users_view'));
        }
        return "wave doesn't exist";
    }

    public function showComputers($IdWave)
    {
        $wave = Wave::where('IdWave', $IdWave)->first();
        $text = trim(request('text'));
        if ($text != null) {
            $computers = Computer::where('SerialNumber', 'LIKE', '%' . $text . '%')->where('Status', 'InStorage')->orderByDesc('created_at')->get();
            if ($computers->isEmpty()) {
                $computers = Computer::where('HostName', 'LIKE', '%' . $text . '%')->where('Status', 'InStorage')->orderByDesc('created_at')->get();
            }
            return view('assign_computers', compact('wave', 'computers'));
        }

        $computers = Computer::where('Status', 'InStorage')->orderByDesc('created_at')->get();
        if ($wave) {
            return view('assign_computers', compact('wave', 'computers'));
        }
        return "wave doesn't exist";
    }

    public function showUsers($IdWave)
    {
        $wave = Wave::where('IdWave', $IdWave)->first();
        $text = trim(request('text'));
        if ($text != null) {
            $users = User::where('cde', 'LIKE', '%' . $text . '%')->where('Position', 'Agent')->where('status', 'Active')->get();
            if ($users->isEmpty()) {
                $users = User::where('name', 'LIKE', '%' . $text . '%')->where('Position', 'Agent')->where('status', 'Active')->get();
            }
            return view('assign_users', compact('wave', 'users'));
        }
        if ($wave->Name == 'Staff') {
            $users = User::where('privilege', '!=', '40001')->where('status', '!=', 'ActiveFull')->get();
            return view('assign_users', compact('wave', 'users'));
        }
        $users = User::where('Position', 'Agent')->where('status', 'Active')->get();
        if ($wave) {
            return view('assign_users', compact('wave', 'users'));
        }
        return "wave doesn't exist";
    }

    public function assignComputers($IdWave)
    {
        try {
            $wave = Wave::where('IdWave', $IdWave)->first();
            if (is_null(request('assign'))) {
                echo '<script language="javascript">alert("Nothing selected");</script>';
                return view('wave_home', compact('wave'));
            }
            foreach (request('assign') as $value) {

                DB::table('wave_employees')->updateOrInsert(['IdWave' => $IdWave, 'SerialNumberComputer' => $value], ['SerialNumberComputer' => $value]);

                DB::table('computers')->where('SerialNumber', $value)->update(['Status' => 'Taken']);
            }
            return redirect()->to('/home/wave/' . $IdWave)->with(['message' => 'Successful', 'alert' => 'success']);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $IdWave)->with(['message' => 'Error, try again ' . $th, 'alert' => 'danger']);
        }
    }

    public function assignUsers($IdWave)
    {
        try {
            $wave = Wave::where('IdWave', $IdWave)->first();
            if (is_null(request('assign'))) {
                echo '<script language="javascript">alert("Nothing selected");</script>';
                return view('wave_home', compact('wave'));
            }
            foreach (request('assign') as $value) {

                DB::table('wave_employees')->updateOrInsert(['IdWave' => $IdWave, 'cde' => $value], ['cde' => $value]);

                DB::table('users')->where('cde', $value)->update(['status' => 'ActiveFull']);
            }

            return redirect()->to('/home/wave/' . $IdWave)->with(['message' => 'Successful', 'alert' => 'success']);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $IdWave)->with(['message' => 'Error, try again ' . $th, 'alert' => 'danger']);
        }
    }

    public function unassignComputer($IdWave, $SerialNumber)
    {
        try {
            DB::table('wave_employees')->where('IdWave', $IdWave)->where('SerialNumberComputer', $SerialNumber)->update(['SerialNumberComputer' => null]);
            DB::table('computers')->where('SerialNumber', $SerialNumber)->update(['Status' => 'InStorage']);
            return redirect()->to('/home/wave/' . $IdWave)->with(['message' => 'Successful', 'alert' => 'success']);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $IdWave)->with(['message' => 'Error, try again', 'alert' => 'danger']);
        }
    }

    public function unassignUser($IdWave, $cde)
    {
        try {
            DB::table('wave_employees')->where('IdWave', $IdWave)->where('cde', $cde)->update(['cde' => null]);
            DB::table('users')->where('cde', $cde)->update(['status' => 'Active']);
            return redirect()->to('/home/wave/' . $IdWave)->with(['message' => 'Successful', 'alert' => 'success']);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $IdWave)->with(['message' => 'Error, try again', 'alert' => 'danger']);
        }
    }

    public function assignComputerUser($IdWave, $SerialNumber)
    {
        try {
            $celdas = DB::table('wave_employees')->where('IdWave', $IdWave)->where('SerialNumberComputer', null)
                ->where('cde', request('UserCode'))
                ->get();

            if (sizeof($celdas) == 1) {
                DB::table('wave_employees')->where('IdWave', $IdWave)->where('SerialNumberComputer', $SerialNumber)
                    ->update(['SerialNumberComputer' => null]);
                DB::table('wave_employees')->where('IdWave', $IdWave)->where('SerialNumberComputer', null)
                    ->where('cde', request('UserCode'))
                    ->update(['SerialNumberComputer' => $SerialNumber]);
            } else {
                return redirect()->to('/home/wave/' . $IdWave)->with(['message' => 'Error, user is already assigned or does not correspond to the wave', 'alert' => 'danger']);
            }
            return redirect()->to('/home/wave/' . $IdWave)->with(['message' => 'Successful', 'alert' => 'success']);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $IdWave)->with(['message' => 'Error, try again' . $th, 'alert' => 'danger']);
        }
    }

    public function updateStatus($cde)
    {
        DB::table('users')->where('cde', $cde)->update(['status' => 'Active']);
    }
}
