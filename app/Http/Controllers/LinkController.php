<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enlaces;
use DB;

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

        foreach (Enlaces::all()->toArray() as $key => $value) {
            if(!array_key_exists($value['categoria'], $enlaces)) {
                $enlaces[$value['categoria']] = [];
            }

            $enlaces[$value['categoria']][] = $value;
        }
        
        $parametros = ['enlaces' => $enlaces];

        return view('lob.enlaces', compact('parametros'));
    }
}