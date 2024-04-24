<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LinkCategory;
use DB;

class LinkCategoryController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin']);
        $parametros = ['titulo'      => 'CATEGORÍAS DE ENLACES',
                       'descripcion' => 'Administra las categorías disponibles para alta de enlaces.',
                       'tabla'       => 'linksCategorias',
                       'urlLista'    => '/admin/request/getlinkcategoria',
                       'urlNuevo'    => route('admin.linkcategoria.create'),
                       'urlEditar'   => '/admin/linkcategoria/'];
        return view('admin.linkCategoria.index', compact('parametros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin']);
        $parametros = ['titulo'      => 'CATEGORÍA NUEVA',
                       'descripcion' => 'Crea y edita información de categoría.',
                       'urlLista'    => '/admin/request/getlinkcategoria',
                       'urlGuardar'  => route('admin.linkcategoria.store'),
                       'urlCancelar' => route('admin.linkcategoria.index')];
        return view('admin.linkCategoria.create', compact('parametros'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin']);
        $request->validate(['categoria' => 'required|max:191']);

        $mensaje = ['tipo'    => 'success',
                    'titulo'  => 'Exito',
                    'mensaje' => 'Registro guardado.'];

        try {
            $registro = LinkCategory::create(['categoria' => request('categoria'),
                                              'estatus'   => request('estatus')!=null?1:0,
                                              'borrado'   => 0]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible guardar el registro.'];
        }

        return redirect()->route('admin.linkcategoria.index')->with('alerta', json_encode($mensaje));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        $request->user()->authorizeRoles(['sa', 'admin']);
        $parametros = ['titulo'      => 'EDITAR CATEGORÍA',
                       'descripcion' => 'Edita información de categoría.',
                       'urlGuardar'  => "/admin/linkcategoria/$id",
                       'urlCancelar' => route('admin.linkcategoria.index'),
                       'datos'       => LinkCategory::findOrFail($id)];
        return view('admin.linkCategoria.create', compact('parametros'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $request->user()->authorizeRoles(['sa', 'admin']);
        $request->validate(['categoria' => 'required|max:191']);

        $mensaje = ['tipo'    => 'success',
                    'titulo'  => 'Exito',
                    'mensaje' => 'Registro actualizado.'];
                    
        try {
            $registro = LinkCategory::where('id', '=', $id)->update(['categoria' => request('categoria'),
                                                                     'estatus'   => request('estatus')!=null?1:0]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible actualizar el registro.'];
        }

        return redirect()->route('admin.linkcategoria.index')->with('alerta', json_encode($mensaje));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        $request->user()->authorizeRoles(['sa', 'admin']);
        $mensaje = ['tipo'    => 'success',
                    'titulo'  => 'Exito',
                    'mensaje' => 'Registro eliminado.'];
        try {
            $registro = LinkCategory::where('id', '=', $id)->update(['borrado' => 1]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible eliminar el registro.'];
        }

        return redirect()->route('admin.linkcategoria.index')->with('alerta', json_encode($mensaje));
    }

    public function getLinkCategorias(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin']);
        $buscar = request('search');
        $orden = request('order');
        $ordenamiento = ['campo' => 'link_categories.categoria',
                         'dir'   => 'desc'];
        $campos = ['link_categories.id', 'link_categories.categoria'];
        if(!empty($orden)) {
            $ordenamiento = ['campo' => $campos[$orden[0]['column']],
                             'dir'   => $orden[0]['dir']];
        }

        $total = LinkCategory::select('link_categories.id')
                             ->when(!empty($buscar['value']) , function($query) use($buscar) {
                                return $query->where('link_categories.categoria', 'LIKE', "%{$buscar['value']}%");
                             })->where('link_categories.borrado', '=', '0')->get();

        $registros = LinkCategory::select('link_categories.id', 'link_categories.categoria', 'link_categories.estatus', DB::raw("DATE_FORMAT(link_categories.created_at, '%d/%m/%Y %H:%i') AS fecha"))
                                 ->when(!empty($buscar['value']) , function($query) use($buscar) {
                                       return $query->where('link_categories.categoria', 'LIKE', "%{$buscar['value']}%"); 
                                 })
                                 ->where('link_categories.borrado', '=', '0')
                                 ->orderBy($ordenamiento['campo'], $ordenamiento['dir'])
                                 ->skip(request('start'))->take(request('length'))->get();

        $datos = [];
        foreach ($registros as $key => $value) {
            $datos[] = [$value->categoria,
                        $value->estatus==1?'<i class="fas fa-check-circle txtCorrecto me-1"></i> Activo':'<i class="far fa-circle txtAdvertencia me-1"></i> Inactivo',
                        $value->fecha,
                        '<a href="editar" data-id="'.$value->id.'" class="btn btn-outline-dark btn-sm" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                         <a href="eliminar" data-id="'.$value->id.'" class="btn btn-outline-dark btn-sm" title="Borrar"><i class="fas fa-trash"></i></a>'];
        }

        $resultado = ['draw'            => request('draw'),
                      'recordsTotal'    => $total->count(),
                      'recordsFiltered' => $total->count(),
                      'data'            => $datos];

        return response()->json($resultado, 201);
    }
}