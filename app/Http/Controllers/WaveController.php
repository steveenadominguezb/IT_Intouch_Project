<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\User;
use App\Models\Wave;
use App\Models\WaveEmployee;
use App\Models\WaveLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\returnValueMap;

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

        $wave = Wave::where('Name', request('floatingName'))->orderByDesc('created_at')->first();

        $wave_location = new WaveLocation();
        $wave_location->IdWave = $wave->IdWave;
        $wave_location->IdLocation = request('floatingSelectLocation');

        $wave_location->save();

        return back();
    }

    public function create($IdWave, $location)
    {
        $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
        $i = 101;
        while (!$wave) {
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $i)->first();
            $i += 100;
        }
        $computers_view = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)
            ->join('computers', 'wave_employees.SerialNumberComputer', '=', 'computers.SerialNumber')
            ->get();

        $users_view = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)
            ->join('users', 'wave_employees.cde', '=', 'users.cde')
            ->get();

        if ($wave) {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            if ($location != $wave->locations->IdLocation) {
                return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $wave->locations->IdLocation . '');
            }
            return view('wave_home', compact('wave', 'locations', 'computers_view', 'users_view'));
        }
        return "wave doesn't exist";
    }

    public function showComputers($IdWave, $location)
    {
        $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
        $text = trim(request('text'));
        if ($text != null) {
            $computers = Computer::where('SerialNumber', 'LIKE', '%' . $text . '%')->where('Status', 'InStorage')->orderByDesc('created_at')->get();
            if ($computers->isEmpty()) {
                $computers = Computer::where('HostName', 'LIKE', '%' . $text . '%')->where('Status', 'InStorage')->orderByDesc('created_at')->get();
            }
            return view('assign_computers', compact('wave', 'computers'));
        }
        $locations = WaveLocation::where('IdWave', $IdWave)->get();
        $computers = Computer::where('Status', 'InStorage')->orderByDesc('created_at')->get();
        if ($wave) {
            return view('assign_computers', compact('wave', 'computers', 'locations'));
        }
        return "wave doesn't exist";
    }

    public function showUsers($IdWave, $location)
    {
        $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
        $text = trim(request('text'));
        if ($text != null) {
            $users = User::where('cde', 'LIKE', '%' . $text . '%')->where('Position', 'Agent')->where('status', 'Active')->get();
            if ($users->isEmpty()) {
                $users = User::where('name', 'LIKE', '%' . $text . '%')->where('Position', 'Agent')->where('status', 'Active')->get();
            }
            return view('assign_users', compact('wave', 'users'));
        }
        $locations = WaveLocation::where('IdWave', $IdWave)->get();
        if ($wave->parent->Name == 'Staff') {
            $users = User::where('privilege', '!=', '40001')->where('status', '!=', 'ActiveFull')->get();
            return view('assign_users', compact('wave', 'users', 'locations'));
        }
        $users = User::where('Position', 'Agent')->where('status', 'Active')->get();
        if ($wave) {
            return view('assign_users', compact('wave', 'users', 'locations'));
        }
        return "wave doesn't exist";
    }

    public function assignComputers($IdWave, $location)
    {
        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();

            if (is_null(request('assign'))) {
                return back()->with(['message' => 'Nothing selected', 'alert' => 'success', 'locations' => $locations]);
            }
            foreach (request('assign') as $value) {

                DB::table('wave_employees')->updateOrInsert(['IdWave' => $wave->IdWaveLocation, 'SerialNumberComputer' => $value], ['SerialNumberComputer' => $value]);

                DB::table('computers')->where('SerialNumber', $value)->update(['Status' => 'Taken']);
            }
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'locations' => $locations]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'locations' => $locations]);
        }
    }

    public function assignUsers($IdWave, $location)
    {
        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
            if (is_null(request('assign'))) {
                return back()->with(['message' => 'Nothing selected', 'alert' => 'success', 'locations' => $locations]);
            }
            foreach (request('assign') as $value) {

                DB::table('wave_employees')->updateOrInsert(['IdWave' => $wave->IdWaveLocation, 'cde' => $value], ['cde' => $value]);

                DB::table('users')->where('cde', $value)->update(['status' => 'ActiveFull']);
            }

            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'locations' => $locations]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'locations' => $locations]);
        }
    }

    public function unassignComputer($IdWave, $location, $SerialNumber)
    {
        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();
            $wave_employees = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->first();

            if ($wave_employees->cde != null) {
                DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->update(['SerialNumberComputer' => null]);
            } else {
                DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->delete();
            }

            DB::table('computers')->where('SerialNumber', $SerialNumber)->update(['Status' => 'InStorage']);

            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'locations' => $locations]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'locations' => $locations]);
        }
    }

    public function unassignUser($IdWave, $location, $cde)
    {
        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();

            $wave_employees = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('cde', $cde)->first();

            if ($wave_employees->SerialNumberComputer != null) {
                DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('cde', $cde)->update(['cde' => null]);
            } else {
                DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('cde', $cde)->delete();
            }

            DB::table('users')->where('cde', $cde)->update(['status' => 'Active']);

            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'locations' => $locations]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'locations' => $locations]);
        }
    }

    public function assignComputerUser($IdWave, $location, $SerialNumber)
    {
        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();

            $celdas = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', null)
                ->where('cde', request('UserCode'))
                ->get();

            if (sizeof($celdas) == 1) {

                $wave_employees = DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->first();

                if ($wave_employees->cde != null) {
                    DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->update(['SerialNumberComputer' => null]);
                } else {
                    DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', $SerialNumber)->delete();
                }

                DB::table('wave_employees')->where('IdWave', $wave->IdWaveLocation)->where('SerialNumberComputer', null)
                    ->where('cde', request('UserCode'))
                    ->update(['SerialNumberComputer' => $SerialNumber]);
            } else {

                return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, user is already assigned or does not correspond to the wave', 'alert' => 'danger', 'locations' => $locations]);
            }
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'locations' => $locations]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $wave->IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'locations' => $locations]);
        }
    }

    public function updateStatus($cde)
    {
        DB::table('users')->where('cde', $cde)->update(['status' => 'Active']);
    }

    public function addLocation($IdWave, $location)
    {
        try {
            $locations = WaveLocation::where('IdWave', $IdWave)->get();
            $wave = WaveLocation::where('IdWave', $IdWave)->where('IdLocation', $location)->first();

            $wave_location = new WaveLocation();
            $wave_location->IdWave = $IdWave;
            $wave_location->IdLocation = request('floatingSelectLocation');
            $wave_location->save();

            return redirect()->to('/home/wave/' . $IdWave . '/' . $location . '')->with(['message' => 'Successful', 'alert' => 'success', 'locations' => $locations]);
        } catch (\Throwable $th) {
            return redirect()->to('/home/wave/' . $IdWave . '/' . $location . '')->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger', 'locations' => $locations]);
        }
    }
}
