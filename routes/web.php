<?php

use Illuminate\Support\Facades\Route;
use App\Models\Avisos;
use App\Models\Cumples;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $city = 'Tlaquepaque';
    $key = config('services.owm.key');

    $parametros = ['avisos'  => Avisos::all()->skip(0)->take(5),
                   'cumples' => Cumples::all()];

    /*$response = Http::get("https://api.openweathermap.org/data/2.5/weather?q=".$city."&lang=es"."&appid=".$key)->json();
    if($response['cod'] == "200") {
        $parametros = ['weather' => $response['weather'][0]['description'],
                       'main'    => $response['weather'][0]['main'],
                       'temp'    => $response['main']['temp'] - 273,
                       'name'    => $response['name'],
                       'country' => $response['sys']['country'],
                       'ok'      => $response['cod']];
    }*/

    return view('welcome', compact('parametros'));
});

 // Auth::routes();
Auth::routes(['register' => false,
              'reset'    => false,
              'verify'   => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/lob/{seccion}', function ($seccion) {
    return view("lob.$seccion");
});

// Avisos
Route::match(array('GET', 'POST'), '/lista/{pagina}/avisos', 'App\Http\Controllers\NoticeController@getAvisosLista')->name('lista.avisos');
Route::match(array('GET', 'POST'), '/aviso/{id}/{titulo}', 'App\Http\Controllers\NoticeController@getDetalle')->name('aviso.getdetalle');

// Perfil
Route::resource('/perfiles', App\Http\Controllers\ProfileController::class)->names('perfiles');
Route::match(array('GET', 'POST'), '/perfil/request/setclave', 'App\Http\Controllers\ProfileController@setClave')->name('perfil.request.clave');
Route::match(array('GET', 'POST'), '/perfil/request/setfoto', 'App\Http\Controllers\ProfileController@setFoto')->name('perfil.request.foto');
Route::match(array('GET', 'POST'), '/perfil/request/setfondo', 'App\Http\Controllers\ProfileController@setFondo')->name('perfil.request.fondo');

// Links
Route::resource('/enlaces', App\Http\Controllers\LinkController::class)->names('enlaces');
Route::match(array('GET', 'POST'), '/enlaces/{directorio}/directorio', 'App\Http\Controllers\LinkController@index')->name('enlaces.getfiles');

// Nuestra Gente
Route::match(array('GET', 'POST'), '/lista/{pagina}/contenidos', 'App\Http\Controllers\PeopleController@getContenidosLista')->name('lista.contenidos');
Route::match(array('GET', 'POST'), '/contenido/{id}/{titulo}', 'App\Http\Controllers\PeopleController@getDetalle')->name('contenido.getdetalle');

// Rutas administrador
Route::name('admin.')->prefix('admin')->middleware(['auth'])->group(function () {
    // Aviso Categorías
    Route::resource('/avisocategoria', App\Http\Controllers\Admin\NoticeCategoryController::class)->names('avisocategoria');
    Route::match(array('GET', 'POST'), '/request/getavisocategoria', 'App\Http\Controllers\Admin\NoticeCategoryController@getAvisoCategorias')->name('request.avisocategoria');

    // Publicar Aviso
    Route::resource('/aviso', App\Http\Controllers\Admin\NoticeController::class)->names('aviso');
    Route::match(array('GET', 'POST'), '/request/getavisos', 'App\Http\Controllers\Admin\NoticeController@getAvisos')->name('request.avisos');

    // Link Categoría
    Route::resource('/linkcategoria', App\Http\Controllers\Admin\LinkCategoryController::class)->names('linkcategoria');
    Route::match(array('GET', 'POST'), '/request/getlinkcategoria', 'App\Http\Controllers\Admin\LinkCategoryController@getLinkCategorias')->name('request.linkcategoria');

    // Publicar Link
    Route::resource('/link', App\Http\Controllers\Admin\LinkController::class)->names('link');
    Route::match(array('GET', 'POST'), '/request/getlinks', 'App\Http\Controllers\Admin\LinkController@getLinks')->name('request.links');

    // Publicar Nuestra Gente
    Route::resource('/contenido', App\Http\Controllers\Admin\PeopleController::class)->names('contenido');
    Route::match(array('GET', 'POST'), '/request/getcontenidos', 'App\Http\Controllers\Admin\PeopleController@getContenidos')->name('request.contenidos');
});