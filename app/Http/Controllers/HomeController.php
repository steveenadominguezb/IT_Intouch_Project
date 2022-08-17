<?php

namespace App\Http\Controllers;

use App\Models\Wave;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance with privileges validations.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * Busca la información de las waves y las ordena segun su fecha de entrega.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $last_sunday = strtotime("last Sunday");
        $last_sunday = date("Y-m-d", $last_sunday);

        $previous_week = strtotime("-1 week +1 day");

        $start_week = strtotime("last sunday midnight", $previous_week);
        $end_week = strtotime("next saturday", $start_week);

        $start_week = date("Y-m-d", $start_week);
        $end_week = date("Y-m-d", $end_week);


        $waves = Wave::where('StartDate', '>', $last_sunday)->get();
        $waves_last_week = Wave::where('StartDate', '>', $start_week)->where('StartDate', '<', $end_week)->get();

        $text = request('text');
        if ($text == null) {
            $search_wave = Wave::all();
        }

        $search_wave = Wave::where('Name', 'LIKE', '%' . $text . '%')->latest()->get();
        if ($search_wave->isEmpty()) {
            $search_wave = Wave::where('StartDate', 'LIKE', '%' . $text . '%')->latest()->get();
        }
        return view('home', compact("waves", "waves_last_week", "search_wave"));
    }
}
