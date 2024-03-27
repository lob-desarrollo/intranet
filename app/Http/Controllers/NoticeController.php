<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NoticeCategory;
use App\Models\Notice;
use DB;

class NoticeController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function getDetalle(Request $request, $id) {
        $request->user()->authorizeRoles(['user', 'admin']);
        $aviso = Notice::select('notices.titulo', 'notices.contenido', 'notices.imagen', 'notices.inicia', 'notices.termina', DB::raw("DATE_FORMAT(notices.created_at, '%d.%m.%Y') AS fecha"),
                                'notice_categories.categoria', DB::raw("notice_categories.imagen AS icono"), 'notice_categories.color')
                       ->leftjoin('notice_categories', 'notices.categoria_id', '=', 'notice_categories.id')
                       ->where('notices.id', '=', $id)
                       ->get();
        $parametros = ['aviso' => $aviso[0]];
        
        return view('lob.aviso', compact('parametros'));
    }
}