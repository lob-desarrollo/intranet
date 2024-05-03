<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use App\Models\NuestraGente;
use DB;

class PeopleController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function getContenidosLista(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);
        $inicio=0;
        $paginado = 12;
        if(request('pagina') != null) {
            $inicio = (request('pagina')-1)*$paginado;
        }

        $paginas = ceil(NuestraGente::count()/$paginado);
        $contenidos = NuestraGente::select('nuestra_gente.id', 'nuestra_gente.nombre', 'nuestra_gente.avatar', 'nuestra_gente.puesto', 'nuestra_gente.departamento')
                                  ->skip($inicio)->take($paginado)->get();

        $parametros = ['paginas'     => $paginas,
                       'pagina'      => request('pagina'),
                       'contenidos'  => $contenidos];

        return view('lob.contenidolista', compact('parametros'));
    }

    public function getDetalle(Request $request, $id) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);
        $contenido = People::select('users.name', DB::raw("CONCAT(profiles.nombres, ' ', profiles.apellidos) AS 'nombre'"), 'people.contenido', 'people.imagen')
                           ->leftjoin('users', 'people.user_id', '=', 'users.id')
                           ->leftjoin('profiles', 'people.user_id', '=', 'profiles.user_id')
                           ->where('people.id', '=', $id)
                           ->get();
        $parametros = ['contenido' => $contenido[0]];
        
        return view('lob.contenido', compact('parametros'));
    }
}