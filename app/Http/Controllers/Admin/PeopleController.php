<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;
use DB;
use Storage;
use File;

class PeopleController extends Controller {
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
        $parametros = ['titulo'      => 'PUBLICAR CONTENIDO',
                       'descripcion' => 'Administra contenido que se publican en la sección nuestra gente.',
                       'tabla'       => 'listaContenido',
                       'urlLista'    => '/admin/request/getcontenidos',
                       'urlNuevo'    => route('admin.contenido.create'),
                       'urlEditar'   => '/admin/contenido/'];
        return view('admin.contenidos.index', compact('parametros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin']);
        $parametros = ['titulo'      => 'CONTENIDO NUEVO',
                       'descripcion' => 'Crea y edita contenido publicados en el sitio.',
                       'urlLista'    => '/admin/request/getcontenido',
                       'urlGuardar'  => route('admin.contenido.store'),
                       'urlCancelar' => route('admin.contenido.index')];
        return view('admin.contenidos.create', compact('parametros'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin']);
        $request->validate(['titulo'       => 'required|max:191',
                            'resumen'      => 'required',
                            'contenido'    => 'required',
                            'imagen'    => 'required']);

        $mensaje = ['tipo'    => 'success',
                    'titulo'  => 'Exito',
                    'mensaje' => 'Registro guardado.'];

        try {
            $archivo = 'imagen_ejemplo.png';
            if ($request->file('imagen')) {
                $extencion = $request->file('imagen')->getClientOriginalExtension();
                $archivo = time().'.'.$extencion;
                $path = $request->file('imagen')->storeAs('public/contents', $archivo);
            }

            $registro = People::create(['titulo'       => request('titulo'),
                                        'resumen'      => request('resumen'),
                                        'contenido'    => request('contenido'),
                                        'imagen'       => $archivo,
                                        'estatus'      => request('estatus')!=null?1:0]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible guardar el registro.'];
        }

        return redirect()->route('admin.contenido.index')->with('alerta', json_encode($mensaje));
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
        $parametros = ['titulo'      => 'EDITAR CONTENIDO',
                       'descripcion' => 'Edita contenidos publicados en el sitio',
                       'urlGuardar'  => "/admin/contenido/$id",
                       'urlCancelar' => route('admin.contenido.index'),
                       'datos'       => People::findOrFail($id)];
        return view('admin.contenidos.create', compact('parametros'));
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
        $request->validate(['titulo'       => 'required|max:191',
                            'resumen'      => 'required',
                            'contenido'    => 'required']);

        $mensaje = ['tipo'    => 'success',
                    'titulo'  => 'Exito',
                    'mensaje' => 'Registro actualizado.'];
                    
        try {
            $datos = People::findOrFail($id);
            $archivo = $datos->imagen;
            if ($request->file('imagen')) {
                if(Storage::exists('public/contents/'.$archivo)){
                    Storage::delete('public/contents/'.$archivo);
                }

                $extencion = $request->file('imagen')->getClientOriginalExtension();
                $archivo = time().'.'.$extencion;
                $path = $request->file('imagen')->storeAs('public/contents', $archivo);
            }

            $registro = People::where('id', '=', $id)->update(['titulo'       => request('titulo'),
                                                               'resumen'      => request('resumen'),
                                                               'contenido'    => request('contenido'),
                                                               'imagen'       => $archivo,
                                                               'estatus'      => request('estatus')!=null?1:0]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible actualizar el registro.'];
        }

        return redirect()->route('admin.contenido.index')->with('alerta', json_encode($mensaje));
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
            $datos = People::findOrFail($id);
            if(Storage::exists('public/contents/'.$datos->imagen)){
                Storage::delete('public/contents/'.$datos->imagen);
            }
            $registro = People::where('id', '=', $id)->delete();
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible eliminar el registro.'];
        }

        return redirect()->route('admin.contenido.index')->with('alerta', json_encode($mensaje));
    }

    public function getContenidos(Request $request) {
        $request->user()->authorizeRoles(['sa', 'admin', 'user']);
        $buscar = request('search');
        $orden = request('order');
        $ordenamiento = ['campo' => 'people.id',
                         'dir'   => 'desc'];
        $campos = ['people.id', 'people.titulo', 'people.resumen', 'people.contenido', 'people.imagen'];
        if(!empty($orden)) {
            $ordenamiento = ['campo' => $campos[$orden[0]['column']],
                             'dir'   => $orden[0]['dir']];
        }

        $total = People::select('people.id')
                       ->when(!empty($buscar['value']) , function($query) use($buscar) {
                            return $query->where('people.titulo', 'LIKE', "%{$buscar['value']}%")
                                         ->orWhere('people.resumen', 'LIKE', "%{$buscar['value']}%")
                                         ->orWhere('people.contenido', 'LIKE', "%{$buscar['value']}%");
                       })->get();

        $registros = People::select('people.id', 'people.titulo', 'people.estatus', 
                                    DB::raw("DATE_FORMAT(people.created_at, '%d.%m.%Y %H:%i') AS fecha"))
                           ->when(!empty($buscar['value']) , function($query) use($buscar) {
                               return $query->where('people.titulo', 'LIKE', "%{$buscar['value']}%")
                                            ->orWhere('people.resumen', 'LIKE', "%{$buscar['value']}%")
                                            ->orWhere('people.contenido', 'LIKE', "%{$buscar['value']}%");
                           })
                           ->orderBy($ordenamiento['campo'], $ordenamiento['dir'])
                           ->skip(request('start'))->take(request('length'))->get();

        $datos = [];
        foreach ($registros as $key => $value) {
            $datos[] = [$value->titulo,
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