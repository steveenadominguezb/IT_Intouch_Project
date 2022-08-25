<?php

namespace App\Http\Controllers;

use App\Models\Attrition;
use App\Models\Computer;
use App\Models\User;
use App\Models\Wave;
use App\Models\WaveEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttritionController extends Controller
{
    /**
     * Metodo contructor que valida el inicio de sesion
     * y los privilegios necesarios para acceder
     */
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('auth');
    }

    /**
     * Metodo para traer todos los registros de la tabla attrition,
     * devuelve la vista con la variable rows 
     */

    public function index()
    {
        $rows = Attrition::latest()->get();
        return view('attrition', compact('rows'));
    }

    /**
     * El metodo store tiene como objetivo insertar
     * un nuevo registro en la tabla de attrition
     */

    public function store()
    {
        try {
            // Almacena el nombre del usuario dado en el formulario
            $name_user = request('name_user');
            // Almacena el codigo del usuario dado en el formulario
            $cde_user = request('cde');
            // Busca los usuarios que tenga el nombre dado
            $user = User::where('name', 'LIKE', '%' . $name_user . '%')
                ->get();
            // Valida si hay varios o un usuario con el nombre suministrado
            if (sizeof($user) >= 1) {
                //Valida si hay un unico usuario con ese nombre
                if (sizeof($user) == 1) {
                    // Busca el registro del usuario con wave, campaña y computador asignado.
                    $wave_employee = WaveEmployee::where('cde', $user[0]->cde)->first();
                } else {
                    // Como hay varios usuarios con el mismo nombre, valida si ingresaron algun codigo de empleado
                    if ($cde_user) {
                        // Busca el usuario con el nombre y codigo diligenciado
                        $user = User::where('name', 'LIKE', '%' . $name_user . '%')->where('cde', $cde_user)->first();
                        // Valida si hay algun usuairo con esos datos
                        if (!$user) {
                            //Devuelve un mensaje diciendo que el codigo es invalido porque no encontró registro alguno
                            return back()->with(['message' => 'invalid employee code', 'alert' => 'warning']);
                        }
                        // Busca el registro asociado a ese usuario con unico codigo, guardando datos como la wave, campaña y computador asignado.
                        $wave_employee = WaveEmployee::where('cde', $user->cde)->first();
                    } else {
                        // Retorna un mensaje diciendo que hay muchos usuarios con el mismo nombre y que debe proporcionar algun codigo de empleado.
                        return back()->with(['message' => 'There are many records with the same name, please try again and enter the employee code', 'alert' => 'warning']);
                    }
                }
                // Valida si hay algún registro con ese usuario relacionado con una wave, campaña y computador.
                if ($wave_employee) {
                    // Crea una instancia de la table attrition
                    $attrition = new Attrition();
                    // Añade el codigo del empleado a esa instancia
                    $attrition->cde = $wave_employee->cde;
                    // Añade el id del programa a esa instancia
                    $attrition->IdProgram = $wave_employee->parent->parent->programs->IdProgram;
                    // Verifica si el usuario tiene asignado un computador
                    if ($wave_employee->SerialNumberComputer != null) {
                        // Añade el computador asignado a la instancia
                        $attrition->SerialNumber = $wave_employee->SerialNumberComputer;
                    }
                    // Añade la fecha a la instancia
                    $attrition->attrition_date = now();
                    // Guarda la instancia en la base de datos
                    $attrition->save();
                } else {
                    // Retorna un mensaje diciendo que el usuario no está asignado a alguna wave y que por lo tanto no hay registros asociados a ese usuario.
                    return back()->with(['message' => 'This user(' . $name_user . ') is not assigned to a wave', 'alert' => 'warning']);
                }
            } else {
                // Retorna un mensaje tipo warning advirtiendo que no hay usuarios registrados con ese nombre
                return back()->with(['message' => 'This user(' . $name_user . ') is not already registered', 'alert' => 'warning']);
            }
            return back();
        } catch (\Throwable $th) {
            // Si en algun momento se encontró algun error imprevisto, devuelve un mensaje de error con una descripción.
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }


    /**
     * El método update tiene el objetivo de actualizar un registro del attrition
     * dependiendo del tipo (attrition o exchange) 
     */
    public function update()
    {
        try {
            // Busca el regristro del attrition que se está trabajando
            $attrition = Attrition::find(request('id'));
            // Valida el tipo
            switch (request('wfs')) {
                    // Caso de attrition
                case 'attrition':
                    // Busca el registro de información del empleado
                    $wave_employee = WaveEmployee::where('cde', request('cde'))->where('attrition', 0)->first();
                    // Establece ese registro como un attrition
                    $wave_employee->attrition = true;
                    // Guarda el registro modificado
                    $wave_employee->save();

                    // Busca el usuario en la db
                    $user = User::where('cde', request('cde'))->first();
                    // Establece al usuario en un estado de Inactive
                    $user->status = "Inactive";
                    // Guarda el usuario modificado
                    $user->save();

                    // Valida si el usuario tiene computador asignado y si ya lo devolvió
                    if (request('serial') && request('returned') == 'yes') {
                        // Busca el computador asociado con ese serial
                        $computer = Computer::where('SerialNumber', request('serial'))->first();
                        // Establece al computador a un estado de InStorage
                        $computer->Status = "InStorage";
                        // Actualiza la información del computador en la db
                        $computer->save();
                    }

                    // Busca el registro del attrition que se está manejando
                    $attrition = Attrition::find(request('id'));
                    // Actualiza el registro como un attrition
                    $attrition->wfs_attrition = request('wfs');
                    // Actualiza el campo que verifica si el computador fue devuelto por el usuario
                    $attrition->hardware_returned = request('returned');
                    // Actualiza la fecha del test
                    $attrition->tested_date = now();
                    // Actualiza el registro en la db
                    $attrition->save();
                    // Dirige a la vista del attrition
                    return back();

                    break;

                    // Caso de exchange
                case 'exchange':
                    // Busca el regristro del attrition que se está trabajando
                    $attrition = Attrition::find(request('id'));

                    // Se valida que se haya ingresado un hostname de un equipo nuevo
                    if (request('new_host') == null) {
                        // Devuelve un mensaje diciendo que porfavor ingrese un workstation en el campo
                        return back()->with(['message' => 'Enter the workstation of the new computer', 'alert' => 'warning']);
                    }

                    // Valida que tenga equipo viejo y que se haya devuelto
                    if (request('serial') && request('returned') == 'yes') {

                        // Busca el equipo viejo
                        $computer = Computer::where('SerialNumber', request('serial'))->first();
                        // Cambia el estado del equipo viejo por InStorage
                        $computer->Status = "InStorage";
                        // Guarda los cambios
                        $computer->save();

                        // Actualiza el campo del registro del attrition para indicar que el computador viejo se devuelve o no
                        $attrition->hardware_returned = request('returned');
                        // Actualiza la fecha del testeo del attrition
                        $attrition->tested_date = now();
                        // Guarda los cambios
                        $attrition->save();
                    }

                    // Busca el computador nuevo
                    $new_computer = Computer::where('HostName', request('new_host'))->first();
                    // Valida que exista el computador y que esté en Storage
                    if (!$new_computer || $new_computer->Status != "InStorage") {
                        // Retorna un mensaje diciendo que el computador no existe o ya está asignado
                        return back()->with(['message' => "This computer (" . request('new_host') . ") is not registered or is already deployed", 'alert' => 'warning']);
                    }

                    // Busca el registro de información del usuario con la wave
                    $wave_employee = WaveEmployee::where('cde', request('cde'))->first();
                    // Actualiza el computador que tiene asignado el usuario
                    $wave_employee->SerialNumberComputer = $new_computer->SerialNumber;

                    // Actualiza el estado del nuevo computador por Deployed
                    $new_computer->Status = "Deployed";
                    // Guarda los cambios del nuevo computador
                    $new_computer->save();
                    // Guarda los cambios del registro de información del usuario
                    $wave_employee->save();

                    // Actualiza el tipo de registro del attrition
                    $attrition->wfs_attrition = request('wfs');
                    // Actualiza el campo que valida la devolución del equipo viejo
                    $attrition->hardware_returned = request('returned');
                    // Actualiza la fecha del registro del attrition
                    $attrition->tested_date = now();
                    // Actualiza el campo del equipo nuevo del attrition
                    $attrition->NewSerialNumber = $new_computer->SerialNumber;
                    // Guarda los cambios del attrition
                    $attrition->save();

                    // Retorna a la vista del attrition
                    return back();

                    break;
                case 'transfer':
                    if (!request('new_wave')) {
                        return back()->with(['message' => "The new wave column is required", 'alert' => 'warning']);
                    }
                    $wave = Wave::where('Name', request('new_wave'))->first();
                    if (!$wave) {
                        return back()->with(['message' => "This Wave [" . request('new_wave') . "] is not registered.", 'alert' => 'warning']);
                    }
                    $wave_employee = WaveEmployee::where('cde', request('cde'))->where('attrition', 0)->first();
                    if (!$wave_employee) {
                        return back()->with(['message' => 'This user(' . request('name') . ') is not assigned to a wave', 'alert' => 'warning']);
                    }

                    $new_wave_employee = new WaveEmployee();
                    $new_wave_employee->Date = now();
                    $new_wave_employee->cde = $wave_employee->cde;
                    $new_wave_employee->SerialNumberKey = $wave_employee->SerialNumberKey;
                    $new_wave_employee->SerialNumberComputer = $wave_employee->SerialNumberComputer;

                    $id_location = $wave_employee->parent->location->IdLocation;
                    foreach ($wave->locations as $wave_location) {
                        if ($wave_location->IdLocation == $id_location) {
                            $new_wave_employee->IdWave = $wave_location->IdWaveLocation;
                        }
                    }
                    $wave_employee->attrition = true;
                    $wave_employee->save();
                    $new_wave_employee->save();

                    // Actualiza el tipo de registro del attrition
                    $attrition->wfs_attrition = request('wfs');
                    // Actualiza el campo que valida la devolución del equipo viejo
                    $attrition->hardware_returned = request('returned');
                    $attrition->new_wave = request('new_wave');
                    // Actualiza la fecha del registro del attrition
                    $attrition->tested_date = now();
                    // Guarda los cambios del attrition
                    $attrition->save();

                    return back();
                    break;
                default:
                    // Retorna un mensaje indicando que debe seleccionar un tipo de attrition
                    return back()->with(['message' => 'select a option: attrition or work on site in wfs-attrition', 'alert' => 'warning']);
                    break;
            }
            // Retorna un mensaje de successful
            return back()->with(['message' => 'Success', 'alert' => 'success']);
        } catch (\Throwable $th) {
            // Si algo salió mal de imprevisto, retorna un mensaje con una descripción del problema
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
        // Retorna a la vista del attrition
        return back();
    }


    /**
     * Método para borrar un registro del attrition
     */
    public function deleteUser()
    {
        try {
            // Busca el registro que se quiere borrar y lo borra
            $attrition = Attrition::find(request('id'))->delete();
            // Retorna un mensaje de successful
            return back()->with(['message' => 'Success', 'alert' => 'success']);
        } catch (\Throwable $th) {
            // Si algo salió mal, retorna un mensaje de error con una descripción
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }


    /**
     * Método para agregar un comentario al registro
     */
    public function addComment()
    {
        try {
            // Se busca el registro en cuestión
            $attrition = Attrition::find(request('id'));
            // Actualiza el valor que tenga en el campo de comentario
            $attrition->comments = request('comment');
            // Guarda los cambios
            $attrition->save();

            // Retornar un mensaje de successful
            return back()->with(['message' => 'Comment added', 'alert' => 'success']);
        } catch (\Throwable $th) {
            // Si algo salió mal, retorna un mensaje de error con una descripción
            return back()->with(['message' => 'Error, try again', 'th' => $th, 'alert' => 'danger']);
        }
    }
}
