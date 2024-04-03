<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NoticeCategory;
use App\Models\Notice;
use App\Models\Avisos;
use DB;
use Storage;
use File;

class NoticeController extends Controller {
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
        $parametros = ['titulo'      => 'PUBLICAR AVISOS',
                       'descripcion' => 'Administra los avisos que se publican en el sitio.',
                       'tabla'       => 'listaAvisos',
                       'urlLista'    => '/admin/request/getavisos',
                       'urlNuevo'    => route('admin.aviso.create'),
                       'urlEditar'   => '/admin/aviso/'];
        return view('admin.avisos.index', compact('parametros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        $parametros = ['titulo'      => 'PUBLICACIÓN NUEVA',
                       'descripcion' => 'Crea y edita avisos publicados en el sitio.',
                       'urlLista'    => '/admin/request/getaviso',
                       'urlGuardar'  => route('admin.aviso.store'),
                       'urlCancelar' => route('admin.aviso.index'),
                       'categorias'  => NoticeCategory::all()->toArray()];
        return view('admin.avisos.create', compact('parametros'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        $request->validate(['categoria_id' => 'required',
                            'titulo'       => 'required|max:191',
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
                $path = $request->file('imagen')->storeAs('public/notices', $archivo);
            }

            $registro = Notice::create(['categoria_id' => request('categoria_id'),
                                        'titulo'       => request('titulo'),
                                        'resumen'      => request('resumen'),
                                        'contenido'    => request('contenido'),
                                        'imagen'       => $archivo,
                                        'inicia'       => request('inicia'),
                                        'termina'      => request('termina')]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible guardar el registro.'];
        }

        return redirect()->route('admin.aviso.index')->with('alerta', json_encode($mensaje));
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
        $parametros = ['titulo'      => 'EDITAR PUBLICACIÓN',
                       'descripcion' => 'Edita avisos publicados en el sitio',
                       'urlGuardar'  => "/admin/aviso/$id",
                       'urlCancelar' => route('admin.aviso.index'),
                       'datos'       => Notice::findOrFail($id),
                       'categorias'  => NoticeCategory::all()->toArray()];
        return view('admin.avisos.create', compact('parametros'));
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
        $request->validate(['categoria_id' => 'required',
                            'titulo'       => 'required|max:191',
                            'resumen'      => 'required',
                            'contenido'    => 'required']);

        $mensaje = ['tipo'    => 'success',
                    'titulo'  => 'Exito',
                    'mensaje' => 'Registro actualizado.'];
                    
        try {
            $datos = Notice::findOrFail($id);
            $archivo = $datos->imagen;
            if ($request->file('imagen')) {
                if(Storage::exists('public/notices/'.$archivo)){
                    Storage::delete('public/notices/'.$archivo);
                }

                $extencion = $request->file('imagen')->getClientOriginalExtension();
                $archivo = time().'.'.$extencion;
                $path = $request->file('imagen')->storeAs('public/notices', $archivo);
            }

            $registro = Notice::where('id', '=', $id)->update(['categoria_id' => request('categoria_id'),
                                                               'titulo'       => request('titulo'),
                                                               'resumen'      => request('resumen'),
                                                               'contenido'    => request('contenido'),
                                                               'imagen'       => $archivo,
                                                               'inicia'       => request('inicia'),
                                                               'termina'      => request('termina')]);
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible actualizar el registro.'];
        }

        return redirect()->route('admin.aviso.index')->with('alerta', json_encode($mensaje));
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
            $datos = Notice::findOrFail($id);
            if(Storage::exists('public/notices/'.$datos->imagen)){
                Storage::delete('public/notices/'.$datos->imagen);
            }
            $registro = Notice::where('id', '=', $id)->delete();
        } catch(Exception $exception) {
            $mensaje = ['tipo'    => 'error',
                        'titulo'  => 'Error',
                        'mensaje' => 'No fue posible eliminar el registro.'];
        }

        return redirect()->route('admin.aviso.index')->with('alerta', json_encode($mensaje));
    }

    public function getAvisosLista(Request $request) {
        $request->user()->authorizeRoles(['user', 'admin']);
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

    public function getAvisos(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        $buscar = request('search');
        $orden = request('order');
        $ordenamiento = ['campo' => 'notices.id',
                         'dir'   => 'desc'];
        $campos = ['notices.id', 'notices.titulo', 'notices.resumen', 'notices.contenido', 'notices.imagen', 'notices.inicia', 'notices.termina'];
        if(!empty($orden)) {
            $ordenamiento = ['campo' => $campos[$orden[0]['column']],
                             'dir'   => $orden[0]['dir']];
        }

        $total = Notice::select('notices.id')
                       ->leftjoin('notice_categories', 'notices.categoria_id', '=', 'notice_categories.id')
                       ->when(!empty($buscar['value']) , function($query) use($buscar) {
                            return $query->where('notices.titulo', 'LIKE', "%{$buscar['value']}%")
                                         ->orWhere('notices.resumen', 'LIKE', "%{$buscar['value']}%")
                                         ->orWhere('notices.contenido', 'LIKE', "%{$buscar['value']}%")
                                         ->orWhere('notice_categories.categoria', 'LIKE', "%{$buscar['value']}%");
                       })->where('notice_categories.estatus', '=', '1')->get();

        $registros = Notice::select('notices.id', 'notice_categories.categoria', 'notices.titulo', 
                                    DB::raw("DATE_FORMAT(notices.inicia, '%d.%m.%Y') AS inicia"), 
                                    DB::raw("DATE_FORMAT(notices.termina, '%d.%m.%Y') AS termina"), 
                                    DB::raw("DATE_FORMAT(notices.created_at, '%d.%m.%Y %H:%i') AS fecha"))
                           ->leftjoin('notice_categories', 'notices.categoria_id', '=', 'notice_categories.id')
                           ->when(!empty($buscar['value']) , function($query) use($buscar) {
                               return $query->where('notices.titulo', 'LIKE', "%{$buscar['value']}%")
                                            ->orWhere('notices.resumen', 'LIKE', "%{$buscar['value']}%")
                                            ->orWhere('notices.contenido', 'LIKE', "%{$buscar['value']}%")
                                            ->orWhere('notice_categories.categoria', 'LIKE', "%{$buscar['value']}%");
                           })
                           ->where('notice_categories.estatus', '=', '1')
                           ->orderBy($ordenamiento['campo'], $ordenamiento['dir'])
                           ->skip(request('start'))->take(request('length'))->get();

        $datos = [];
        foreach ($registros as $key => $value) {
            $datos[] = [$value->titulo,
                        $value->categoria,
                        $value->inicia,
                        $value->termina,
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