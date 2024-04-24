<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
use App\Models\Avisos;
use DB;

class NoticeController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function getAvisosLista(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);
        $inicio=0;
        $paginado = 10;
        if(request('pagina') != null) {
            $inicio = (request('pagina')-1)*$paginado;
        }

        $paginas = ceil(Avisos::count()/$paginado);
        $avisos = Avisos::select('avisos.categoria', 'avisos.imagen', 'avisos.color', 'avisos.id', 'avisos.titulo', 'avisos.resumen', 'avisos.fecha')
                           ->skip($inicio)->take($paginado)->get();

        $parametros = ['paginas' => $paginas,
                       'pagina'  => request('pagina'),
                       'avisos'  => $avisos];

        return view('lob.avisolista', compact('parametros'));
    }

    public function getDetalle(Request $request, $id) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);
        $aviso = Notice::select('notices.titulo', 'notices.contenido', 'notices.imagen', 'notices.inicia', 'notices.termina', DB::raw("DATE_FORMAT(notices.created_at, '%d.%m.%Y') AS fecha"),
                                'notice_categories.categoria', DB::raw("notice_categories.imagen AS icono"), 'notice_categories.color')
                       ->leftjoin('notice_categories', 'notices.categoria_id', '=', 'notice_categories.id')
                       ->where('notices.id', '=', $id)
                       ->get();
        $parametros = ['aviso' => $aviso[0]];
        
        return view('lob.aviso', compact('parametros'));
    }
}