<?php

use App\Http\Controllers\ComputerController;
use App\Http\Controllers\ComputersController;
use App\Http\Controllers\RegisterEmployeeController;
use App\Http\Controllers\WaveController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
#Ruta pagina principal
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
#Ruta post para insertar una nueva wave
Route::post('/home/insert-wave', [WaveController::class, 'store'])->name('wave.store');

#Ruta que muestra la pagina para registrar un empleado
Route::get('/home/register-employee', [RegisterEmployeeController::class, 'index'])->name('register-employee.index');
#Ruta que valida la información y registra al empleado
Route::post('/home/register-employee', [RegisterEmployeeController::class, 'create'])->name('register-employee.create');

#Ruta que muestra la pagina para registrar un computador
Route::get('/home/register-computer', [ComputerController::class, 'index'])->name('register-computer.index');
#Ruta que valida la información y registra un computador
Route::post('/home/register-computer', [ComputerController::class, 'create'])->name('register-computer.create');

#Ruta que muestra la pagina de edición de la wave
Route::get('/home/wave/{IdWave}', [WaveController::class, 'create'])->name('wave.create');
#Ruta que desasigna un computador
Route::post('/home/wave/{IdWave}/computer/{SerialNumber}', [WaveController::class, 'unassignComputer'])->name('wave.unassign.computer');
#Ruta que desasigna un usuario
Route::post('/home/wave/{IdWave}/user/{cde}', [WaveController::class, 'unassignUser'])->name('wave.unassign.user');

#Ruta que muestra la vista para asignar computadores
Route::get('/home/wave/{IdWave}/computers', [WaveController::class, 'showComputers'])->name('wave.show.computers');
#Ruta que asigna los computadores
Route::post('/home/wave/{IdWave}/computers', [WaveController::class, 'assignComputers'])->name('wave.assign.computers');

#Ruta que muestra la vista para asignar usuarios
Route::get('/home/wave/{IdWave}/users', [WaveController::class, 'showUsers'])->name('wave.show.users');
#Ruta que asigna los computadores
Route::post('/home/wave/{IdWave}/users', [WaveController::class, 'assignUsers'])->name('wave.assign.users');

#Ruta para mostrar lista de computadores
Route::get('/home/computers', [ComputerController::class, 'computersList'])->name('computers.list');
Route::post('/home/computers', [ComputerController::class, 'computersUpdate'])->name('computers.update');
Route::get('/computers/{SerialNumber}', [ComputerController::class, 'computerTracert'])->name('computers.tracert');

Route::post('/assign/{IdWave}/{SerialNumber}', [WaveController::class, 'assignComputerUser']);


#Rutas para el login
Auth::routes();


