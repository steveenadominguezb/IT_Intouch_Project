<?php

use App\Http\Controllers\AttritionController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RegisterEmployeeController;
use App\Http\Controllers\UsersController;
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
    return view('auth.login');
});
#Ruta pagina principal
Route::get('/home', [HomeController::class, 'index'])->name('home');
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
Route::get('/home/wave/{IdWave}/{location}', [WaveController::class, 'create'])->name('wave.create');
#Ruta que muestra la wave con todas sus locations
Route::get('/wave/{IdWave}/all-locations', [WaveController::class, 'allLocations'])->name('wave.all-locations');
#Ruta para eliminar una wave
Route::post('/home/wave/delete', [WaveController::class, 'delete'])->name('wave.delete');


#Ruta para agregar una nueva ubicacion
Route::post('/home/wave/{IdWave}/{location}/new-location', [WaveController::class, 'addLocation'])->name('wave.new-location');
#Ruta que desasigna un computador
Route::post('/home/wave/{IdWave}/{location}/computer/{SerialNumber}', [WaveController::class, 'unassignComputer'])->name('wave.unassign.computer');
#Ruta que desasigna un usuario
Route::post('/home/wave/{IdWave}/{location}/user/{cde}', [WaveController::class, 'unassignUser'])->name('wave.unassign.user');

#Ruta que muestra la vista para asignar computadores
Route::get('/home/wave/{IdWave}/{location}/computers', [WaveController::class, 'showComputers'])->name('wave.show.computers');
#Ruta que asigna los computadores
Route::post('/home/wave/{IdWave}/{location}/computers', [WaveController::class, 'assignComputers'])->name('wave.assign.computers');

#Ruta que muestra la vista para asignar usuarios
Route::get('/home/wave/{IdWave}/{location}/users', [WaveController::class, 'showUsers'])->name('wave.show.users');
#Ruta que asigna los computadores
Route::post('/home/wave/{IdWave}/{location}/users', [WaveController::class, 'assignUsers'])->name('wave.assign.users');
#Ruta que asigna computador a usuario
Route::post('/assign/{IdWave}/{location}/{SerialNumber}', [WaveController::class, 'assignComputerUser']);
#Ruta que asigna computadores a usuarios maxivamente
Route::post('/home/wave/{IdWave}/{location}', [WaveController::class, 'relateEverything']);


#Ruta para mostrar lista de computadores
Route::get('/home/computers', [ComputerController::class, 'computersList'])->name('computers.list');
Route::post('/home/computers', [ComputerController::class, 'computersUpdate'])->name('computers.update');
Route::get('/computers/{SerialNumber}', [ComputerController::class, 'computerTracert'])->name('computers.tracert');
Route::get('/computers/blacklist/{SerialNumber}', [ComputerController::class, 'inBlackList'])->name('computers.blacklist');


#Ruta para mostrar lista de usuarios
Route::get('/home/users', [UsersController::class, 'index'])->name('users.list');
Route::post('/home/users', [UsersController::class, 'userUpdate'])->name('users.update');
Route::get('/home/users/{cde}', [UsersController::class, 'userTracert'])->name('users.tracert');


#Ruta del attrition
Route::get('/attrition', [AttritionController::class, 'index'])->name('attrition.index');
#Ruta de insertar un usuario al attrition
Route::post('/attrition', [AttritionController::class, 'store'])->name('attrition.store');
#Ruta para actualizar un usuario del attrition
Route::post('/attrition/update_user', [AttritionController::class, 'update'])->name('attrition.update');
#Ruta para borrar un usuario del attrition
Route::post('/attrition/delete_user', [AttritionController::class, 'deleteUser'])->name('attrition.deleteUser');
#Ruta para agregar un comentario al attrition
Route::post('/attrition/add_comment', [AttritionController::class, 'addComment'])->name('attrition.addComment');


#Rutas para el login
Auth::routes();
