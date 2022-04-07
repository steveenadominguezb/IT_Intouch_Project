<?php

use App\Http\Controllers\ComputerController;
use App\Http\Controllers\RegisterEmployeeController;
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

#Ruta que muestra la pagina para registrar un empleado
Route::get('/home/register-employee', [RegisterEmployeeController::class, 'index'])->name('register-employee.index');
#Ruta que valida la información y registra al empleado
Route::post('/home/register-employee', [RegisterEmployeeController::class, 'create'])->name('register-employee.create');

#Ruta que muestra la pagina para registrar un computador
Route::get('/home/register-computer', [ComputerController::class, 'index'])->name('register-computer.index');
#Ruta que valida la información y registra un computador
Route::post('/home/register-computer', [ComputerController::class, 'create'])->name('register-computer.create');

#Rutas para el login
Auth::routes();


