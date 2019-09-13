<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\Http\Controllers\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Auth;

class PropertiesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        ->get();
        
        return view('properties', ['properties' => $properties]);
    }
    
    public function propertiesDisponibles()
    {

        if (!Auth::user()->premium) {
            $properties = DB::table('properties')
            ->where([
                ['available', '=', '1'],
                ['id_usuario', '=', '0'],
                ['tipo', '<>', '1'],
            ])
            ->join('provincias', 'properties.province', '=', 'provincias.id')
            ->join('localidades', 'properties.city', '=', 'localidades.id')
            ->join('semana_propiedad', 'properties.id', '=', 'semana_propiedad.id_propiedad')
            ->select('properties.*', 'provincias.nombre_provincia', 'localidades.nombre_localidad')
            ->distinct()
            ->get();
        }
        else {
            $properties = DB::table('properties')
            ->where([
                ['available', '=', '1'],
                ['id_usuario', '=', '0'],
            ])
            ->join('provincias', 'properties.province', '=', 'provincias.id')
            ->join('localidades', 'properties.city', '=', 'localidades.id')
            ->join('semana_propiedad', 'properties.id', '=', 'semana_propiedad.id_propiedad')
            ->select('properties.*', 'provincias.nombre_provincia', 'localidades.nombre_localidad')
            ->distinct()
            ->get();
        }
        
        return view('properties_disponibles', ['properties' => $properties]);
    }

}
