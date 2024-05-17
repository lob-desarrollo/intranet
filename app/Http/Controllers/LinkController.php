<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enlaces;
use DB;
use Storage;
use File;

class LinkController extends Controller {
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
        $enlaces = [];

        $directorio = 'sistemas-de-calidad';
        if(request('directorio') != null) {
            $directorio = str_replace(['|'], ['/'], request('directorio'));
        }

        $directorios = [];
        foreach (Storage::disk('public')->directories($directorio) as $key => $value) {
            $directorios[] = ['etiqueta'   => basename($value),
                              'directorio' => str_replace(['/'], ['|'], $value)];
        }

        $archivos = [];
        foreach (Storage::disk('public')->files($directorio) as $key => $value) {
            $archivos[] = ['etiqueta' => basename($value),
                           'archivo'  => $value];
        }

        foreach (Enlaces::all()->toArray() as $key => $value) {
            if(!array_key_exists($value['categoria'], $enlaces)) {
                $enlaces[$value['categoria']] = [];
            }

            $enlaces[$value['categoria']][] = $value;
        }

        $url = [];
        $breadcrump = [];
        foreach (explode('/', $directorio) as $key => $value) {
            $url[] = $value;
            if($value != 'sistemas-de-calidad') {
                $breadcrump[] = ['url'      => implode('|', $url),
                                 'etiqueta' => $value];
            }
        }
        
        $parametros = ['enlaces'     => $enlaces,
                       'breadcrump'  => $breadcrump,
                       'directorios' => $directorios,
                       'archivos'    => $archivos];

        return view('lob.enlaces', compact('parametros'));
    }
}