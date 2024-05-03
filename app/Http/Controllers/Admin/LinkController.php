<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\LinkCategory;
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
        $request->user()->authorizeRoles(['sa', 'admin']);
        $parametros = ['titulo'      => 'PUBLICAR ENLACES',
                       'descripcion' => 'Administra los enlaces que se publican en el sitio.',
                       'tabla'       => 'listaLinks',
                       'urlLista'    => '/admin/request/getlinks',
                       'urlNuevo'    => route('admin.link.create'),
                       'urlEditar'   => '/admin/link/'];
        return view('admin.links.index', compact('parametros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin']);
        $parametros = ['titulo'      => 'ENLACE NUEVO',
                       'descripcion' => 'Crea y edita enlaces para publicadar en el sitio.',
                       'urlLista'    => '/admin/request/getlink',
                       'urlGuardar'  => route('admin.link.store'),
                       'urlCancelar' => route('admin.link.index'),
                       'categorias'  => LinkCategory::all()->where('estatus', '=', '1')->toArray()];
        return view('admin.links.create', compact('parametros'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin']);

        $request->validate(['categoria_id' => 'required',
                            'titulo'       => 'required|max:191']);

        $mensaje = ['tipo'    => 'success',
                    'titulo'  => 'Exito',
                    'mensaje' => 'Registro guardado.'];

        try {
            $archivo = null;
            if ($request->file('archivo')) {
                $extencion = $request->file('archivo')->getClientOriginalExtension();
                $archivo = time().'.'.$extencion;
                $path = $request->file('archivo')->storeAs('public/documents', $archivo);
            }

            $registro = Link::create(['categoria_id' => request('categoria_id'),
                                      'titulo'       => request('titulo'),
                                      'url'          => request('url'),
                                      'archivo'      => $archivo,
                                      'local'        => request('local')!=null?1:0,
                                      'estatus'      => request('estatus')!=null?1:0]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible guardar el registro.'];
        }

        return redirect()->route('admin.link.index')->with('alerta', json_encode($mensaje));
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
        $parametros = ['titulo'      => 'EDITAR ENLACE',
                       'descripcion' => 'Edita enlaces publicados en el sitio',
                       'urlGuardar'  => "/admin/link/$id",
                       'urlCancelar' => route('admin.link.index'),
                       'datos'       => Link::findOrFail($id),
                       'categorias'  => LinkCategory::all()->where('estatus', '=', '1')->toArray()];
        return view('admin.links.create', compact('parametros'));
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

        $request->validate(['categoria_id' => 'required',
                            'titulo'       => 'required|max:191']);

        $mensaje = ['tipo'    => 'success',
                    'titulo'  => 'Exito',
                    'mensaje' => 'Registro actualizado.'];
                    
        try {
            $datos = Link::findOrFail($id);
            $archivo = $datos->archivo;
            if ($request->file('archivo')) {
                if(Storage::exists('public/documents/'.$archivo)){
                    Storage::delete('public/documents/'.$archivo);
                }

                $extencion = $request->file('archivo')->getClientOriginalExtension();
                $archivo = time().'.'.$extencion;
                $path = $request->file('archivo')->storeAs('public/documents', $archivo);
            }

            $registro = Link::where('id', '=', $id)->update(['categoria_id' => request('categoria_id'),
                                                             'titulo'       => request('titulo'),
                                                             'url'          => request('url'),
                                                             'archivo'      => $archivo,
                                                             'local'        => request('local')!=null?1:0,
                                                             'estatus'      => request('estatus')!=null?1:0]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible actualizar el registro.'];
        }

        return redirect()->route('admin.link.index')->with('alerta', json_encode($mensaje));
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
            $datos = Link::findOrFail($id);
            if(Storage::exists('public/documents/'.$datos->archivo)){
                Storage::delete('public/documents/'.$datos->archivo);
            }

            $registro = Link::where('id', '=', $id)->delete();
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible eliminar el registro.'];
        }

        return redirect()->route('admin.link.index')->with('alerta', json_encode($mensaje));
    }

    public function getLinks(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);
        $buscar = request('search');
        $orden = request('order');
        $ordenamiento = ['campo' => 'links.titulo',
                         'dir'   => 'desc'];
        $campos = ['links.titulo'];
        if(!empty($orden)) {
            $ordenamiento = ['campo' => $campos[$orden[0]['column']],
                             'dir'   => $orden[0]['dir']];
        }

        $total = Link::select('links.id')
                     ->leftjoin('link_categories', 'links.categoria_id', '=', 'link_categories.id')
                     ->when(!empty($buscar['value']) , function($query) use($buscar) {
                         return $query->where('links.titulo', 'LIKE', "%{$buscar['value']}%")
                                      ->orWhere('links.url', 'LIKE', "%{$buscar['value']}%")
                                      ->orWhere('link_categories.categoria', 'LIKE', "%{$buscar['value']}%");
                     })
                     ->where('link_categories.estatus', '=', '1')->get();

        $registros = Link::select('links.id', 'link_categories.categoria', 'links.titulo', 'links.estatus',
                                    DB::raw("DATE_FORMAT(links.created_at, '%d.%m.%Y %H:%i') AS fecha"))
                           ->leftjoin('link_categories', 'links.categoria_id', '=', 'link_categories.id')
                           ->when(!empty($buscar['value']) , function($query) use($buscar) {
                               return $query->where('links.titulo', 'LIKE', "%{$buscar['value']}%")
                                      ->orWhere('links.url', 'LIKE', "%{$buscar['value']}%")
                                      ->orWhere('link_categories.categoria', 'LIKE', "%{$buscar['value']}%");
                           })
                           ->where('link_categories.estatus', '=', '1')
                           ->orderBy($ordenamiento['campo'], $ordenamiento['dir'])
                           ->skip(request('start'))->take(request('length'))->get();

        $datos = [];
        foreach ($registros as $key => $value) {
            $datos[] = [$value->titulo,
                        $value->categoria,
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