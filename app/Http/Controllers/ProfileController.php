<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use DB;
use Storage;
use File;

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

    public function setFoto(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);

        if ($request->file('imagen')) {
            try {
                $datos = Profile::select('avatar')->where('user_id', '=', Auth::user()->id)->first()->toArray();
                if($datos['avatar'] != null) {
                    if(Storage::exists('public/profiles/'.$datos['avatar'])){
                        Storage::delete('public/profiles/'.$datos['avatar']);
                    }
                }

                $extencion = $request->file('imagen')->getClientOriginalExtension();
                $archivo = time().'.'.$extencion;
                $path = $request->file('imagen')->storeAs('public/profiles', $archivo);
                Profile::where('id', '=', Auth::user()->id)->update(['avatar' => $archivo]);
                return redirect()->route('perfiles.index');
            } catch(Exception $exception) {}
        }

        $perfil = Profile::select('nombres','apellidos',DB::raw("CASE WHEN genero='H' THEN 'Masculino' ELSE 'Femenino' END AS genero"),'nacimiento','ingreso','puesto','movil','telefono','extension','avatar','fondo')
                         ->where('user_id', '=', Auth::user()->id)
                         ->first()->toArray();
        $parametros = ['usuario'     => User::findOrFail(Auth::user()->id)->toArray(),
                       'perfil'      => $perfil,
                       'titulo'      => 'Avatar',
                       'size'        => '200x200',
                       'urlGuardar'  => route('perfil.request.foto'),
                       'urlCancelar' => route('perfiles.index')];

        return view('lob.updimgperfil', compact('parametros'));
    }

    public function setFondo(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);

        if ($request->file('imagen')) {
            try {
                $datos = Profile::select('fondo')->where('user_id', '=', Auth::user()->id)->first()->toArray();
                if($datos['fondo'] != null) {
                    if(Storage::exists('public/profiles/'.$datos['fondo'])){
                        Storage::delete('public/profiles/'.$datos['fondo']);
                    }
                }

                $extencion = $request->file('imagen')->getClientOriginalExtension();
                $archivo = time().'.'.$extencion;
                $path = $request->file('imagen')->storeAs('public/profiles', $archivo);
                Profile::where('id', '=', Auth::user()->id)->update(['fondo' => $archivo]);
                return redirect()->route('perfiles.index');
            } catch(Exception $exception) {}
        }

        $perfil = Profile::select('nombres','apellidos',DB::raw("CASE WHEN genero='H' THEN 'Masculino' ELSE 'Femenino' END AS genero"),'nacimiento','ingreso','puesto','movil','telefono','extension','avatar','fondo')
                         ->where('user_id', '=', Auth::user()->id)
                         ->first()->toArray();
        $parametros = ['usuario'     => User::findOrFail(Auth::user()->id)->toArray(),
                       'perfil'      => $perfil,
                       'titulo'      => 'Fondo',
                       'size'        => '2000x600',
                       'urlGuardar'  => route('perfil.request.fondo'),
                       'urlCancelar' => route('perfiles.index')];

        return view('lob.updimgperfil', compact('parametros'));
    }
}