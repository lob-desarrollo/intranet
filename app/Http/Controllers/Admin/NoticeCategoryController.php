<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NoticeCategory;
use DB;

class NoticeCategoryController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        $parametros = ['titulo'      => 'CATEGORÍAS DE AVISOS',
                       'descripcion' => 'Administra las categorías disponibles para alta de avisos.',
                       'tabla'       => 'listaCategorias',
                       'urlLista'    => '/admin/request/getavisocategoria',
                       'urlNuevo'    => route('admin.avisocategoria.create'),
                       'urlEditar'   => '/admin/avisocategoria/'];
        return view('admin.avisoCategoria.index', compact('parametros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        $parametros = ['titulo'      => 'CATEGORÍA NUEVA',
                       'descripcion' => 'Crea y edita información de categoría.',
                       'urlLista'    => '/admin/request/getavisocategoria',
                       'urlGuardar'  => route('admin.avisocategoria.store'),
                       'urlCancelar' => route('admin.avisocategoria.index')];
        return view('admin.avisoCategoria.create', compact('parametros'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        $request->validate(['categoria' => 'required|max:191',
                            'imagen'    => 'required',
                            'color'     => 'required']);

        $mensaje = ['tipo'    => 'success',
                    'titulo'  => 'Exito',
                    'mensaje' => 'Registro guardado.'];

        try {
            $registro = NoticeCategory::create(['categoria' => request('categoria'),
                                                'imagen'    => request('imagen'),
                                                'color'     => request('color'),
                                                'estatus'   => 1]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible guardar el registro.'];
        }

        return redirect()->route('admin.avisocategoria.index')->with('alerta', json_encode($mensaje));
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
        $request->user()->authorizeRoles(['admin']);
        $parametros = ['titulo'      => 'EDITAR CATEGORÍA',
                       'descripcion' => 'Edita información de categoría.',
                       'urlGuardar'  => "/admin/avisocategoria/$id",
                       'urlCancelar' => route('admin.avisocategoria.index'),
                       'datos'       => NoticeCategory::findOrFail($id)];
        return view('admin.avisoCategoria.create', compact('parametros'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $request->user()->authorizeRoles(['admin']);
        $request->validate(['categoria' => 'required|max:191',
                            'imagen'    => 'required',
                            'color'     => 'required']);

        $mensaje = ['tipo'    => 'success',
                    'titulo'  => 'Exito',
                    'mensaje' => 'Registro actualizado.'];
                    
        try {
            $registro = NoticeCategory::where('id', '=', $id)->update(['categoria' => request('categoria'),
                                                                       'imagen'    => request('imagen'),
                                                                       'color'     => request('color')]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible actualizar el registro.'];
        }

        return redirect()->route('admin.avisocategoria.index')->with('alerta', json_encode($mensaje));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        $request->user()->authorizeRoles(['admin']);
        $mensaje = ['tipo'    => 'success',
                    'titulo'  => 'Exito',
                    'mensaje' => 'Registro eliminado.'];
        try {
            $registro = NoticeCategory::where('id', '=', $id)->update(['estatus' => 0]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible eliminar el registro.'];
        }

        return redirect()->route('admin.avisocategoria.index')->with('alerta', json_encode($mensaje));
    }

    public function getAvisoCategorias(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        $buscar = request('search');
        $orden = request('order');
        $ordenamiento = ['campo' => 'notice_categories.categoria',
                         'dir'   => 'desc'];
        $campos = ['notice_categories.id', 'notice_categories.categoria', 'notice_categories.imagen', 'notice_categories.color'];
        if(!empty($orden)) {
            $ordenamiento = ['campo' => $campos[$orden[0]['column']],
                             'dir'   => $orden[0]['dir']];
        }

        $total = NoticeCategory::select('notice_categories.id')
                               ->when(!empty($buscar['value']) , function($query) use($buscar) {
                                   return $query->where('notice_categories.categoria', 'LIKE', "%{$buscar['value']}%");
                               })->where('notice_categories.estatus', '=', '1')->get();

        $registros = NoticeCategory::select('notice_categories.id', 'notice_categories.categoria', 'notice_categories.imagen', 'notice_categories.color', DB::raw("DATE_FORMAT(notice_categories.created_at, '%d/%m/%Y %H:%i') AS fecha"))
                                   ->when(!empty($buscar['value']) , function($query) use($buscar) {
                                       return $query->where('notice_categories.categoria', 'LIKE', "%{$buscar['value']}%"); 
                                   })
                                   ->where('notice_categories.estatus', '=', '1')
                                   ->orderBy($ordenamiento['campo'], $ordenamiento['dir'])
                                   ->skip(request('start'))->take(request('length'))->get();

        $datos = [];
        foreach ($registros as $key => $value) {
            $datos[] = [$value->categoria,
                        '<i class="'.$value->imagen.'"></i>',
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