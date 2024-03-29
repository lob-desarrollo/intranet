<?php

use Illuminate\Support\Facades\Route;
use App\Models\Avisos;

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

    $parametros = ['avisos' => Avisos::all()];

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

 Auth::routes();
/*Auth::routes(['register' => false,
              'reset'    => false,
              'verify'   => false]);*/

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/lob/{seccion}', function ($seccion) {
    return view("lob.$seccion");
});

Route::match(array('GET', 'POST'), '/aviso/{id}/{titulo}', 'App\Http\Controllers\NoticeController@getDetalle')->name('aviso.getdetalle');

Route::name('admin.')->prefix('admin')->middleware(['auth'])->group(function () {
    // Aviso Categorías
    Route::resource('/avisocategoria', App\Http\Controllers\Admin\NoticeCategoryController::class)->names('avisocategoria');
    Route::match(array('GET', 'POST'), '/request/getavisocategoria', 'App\Http\Controllers\Admin\NoticeCategoryController@getAvisoCategorias')->name('request.avisocategoria');

    // Publicar Aviso
    Route::resource('/aviso', App\Http\Controllers\Admin\NoticeController::class)->names('aviso');
    Route::match(array('GET', 'POST'), '/request/getavisos', 'App\Http\Controllers\Admin\NoticeController@getAvisos')->name('request.avisos');
});