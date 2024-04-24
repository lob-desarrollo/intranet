<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use DB;

class ProfileController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);
        $perfil = Profile::select('nombres','apellidos',DB::raw("CASE WHEN genero='H' THEN 'Masculino' ELSE 'Femenino' END AS genero"),'nacimiento','ingreso','puesto','movil','telefono','extension','avatar','fondo')
                         ->where('user_id', '=', Auth::user()->id)
                         ->first()->toArray();
        $parametros = ['usuario' => User::findOrFail(Auth::user()->id)->toArray(),
                       'perfil'  => $perfil];

        return view('lob.perfil', compact('parametros'));
    }

    public function setClave(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);
        $request->validate(['clave' => 'required|min:8']);

        $resultado = ['tipo'    => 'success',
                      'titulo'  => 'Exito',
                      'mensaje' => 'Contraseña actualizada.'];
                    
        try {
            $registro = User::where('id', '=', Auth::user()->id)->update(['password' => Hash::make(request('clave'))]);
        } catch(Exception $exception) {
            $resultado = ['tipo'    => 'error',
                          'titulo'  => 'Error',
                          'mensaje' => 'No fue posible actualizar contraseña.'];
        }

        return response()->json($resultado, 201);
    }
}