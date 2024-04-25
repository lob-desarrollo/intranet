<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use DB;

class PeopleController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function getContenidosLista(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);
        $inicio=0;
        $paginado = 10;
        if(request('pagina') != null) {
            $inicio = (request('pagina')-1)*$paginado;
        }

        $paginas = ceil(People::count()/$paginado);
        $contenidos = People::select('people.imagen', 'people.id', 'people.titulo', 'people.resumen', DB::raw("DATE_FORMAT(people.created_at, '%d.%m.%Y') AS fecha"))
                            ->where('people.estatus', '=', '1')
                            ->orderBy('people.created_at', 'DESC')
                            ->skip($inicio)->take($paginado)->get();

        $parametros = ['paginas'     => $paginas,
                       'pagina'      => request('pagina'),
                       'contenidos'  => $contenidos];

        return view('lob.contenidolista', compact('parametros'));
    }

    public function getDetalle(Request $request, $id) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);
        $contenido = People::select('people.titulo', 'people.contenido', 'people.imagen', DB::raw("DATE_FORMAT(people.created_at, '%d.%m.%Y') AS fecha"))
                       ->where('people.id', '=', $id)
                       ->get();
        $parametros = ['contenido' => $contenido[0]];
        
        return view('lob.contenido', compact('parametros'));
    }
}