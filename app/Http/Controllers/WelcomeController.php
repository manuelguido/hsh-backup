<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {

        $properties = DB::table('properties')
            ->where('available', '1')
            ->join('provincias', 'properties.province', '=', 'provincias.id')
            ->join('localidades', 'properties.city', '=', 'localidades.id')
            ->select('properties.*', 'provincias.nombre_provincia', 'localidades.nombre_localidad')
            ->offset(0)
            ->limit(5)
            ->get();
        
        $provincias = DB::table('provincias')
            ->select('nombre_provincia', 'id')
            ->orderByRaw('nombre_provincia ASC')
            ->get();

        $localidades = DB::table('localidades')
            ->select('nombre_localidad', 'id', 'id_provincia')
            ->orderByRaw('nombre_localidad ASC')
            ->get();

        return view('welcome', ['properties' => $properties, 'provincias' => $provincias, 'localidades' => $localidades]);
    }
}
