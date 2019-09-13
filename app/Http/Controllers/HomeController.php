<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Hash;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
    public function index()
    {
        $id = Auth::user()->id;
        
        $user = DB::table('users')
            ->where('id', $id)
            ->get();

        $solicitudes  = DB::table('solicitudes')
            ->where('user_id', $id)
            ->where('status', 1)
            ->limit(1)
            ->get();

        $userFavoritos = DB::table('favoritos')
            ->where('favoritos.id_usuario', $id)
            ->join('semana_propiedad', 'semana_propiedad.id', 'favoritos.id_sp')
            ->join('semana', 'semana_propiedad.id_semana', 'semana.id')
            ->join('properties', 'properties.id', 'semana_propiedad.id_propiedad')
            ->join('provincias', 'provincias.id', 'properties.province')
            ->join('localidades', 'localidades.id', 'properties.city')
            ->select('favoritos.*', 'favoritos.id AS favid', 'semana_propiedad.*', 'properties.*', 'provincias.*', 'localidades.*')
            ->get();

        $userReservas = DB::table('semana_propiedad')
            ->where('semana_propiedad.id_usuario', $id)
            ->join('semana', 'semana_propiedad.id_semana', 'semana.id')
            ->join('properties', 'properties.id', 'semana_propiedad.id_propiedad')
            ->join('provincias', 'provincias.id', 'properties.province')
            ->join('localidades', 'localidades.id', 'properties.city')
            ->select('semana_propiedad.*', 'semana_propiedad.id AS id_sp', 'properties.*', 'provincias.*', 'localidades.*', 'semana.fecha_inicio', 'semana.fecha_cierre')
            ->get();

        $userSubastas = DB::table('participa_subasta')
            ->where('participa_subasta.id_usuario', $id)
            ->join('semana_propiedad', 'semana_propiedad.id', 'participa_subasta.id_sp')
            ->join('semana', 'semana_propiedad.id_semana', 'semana.id')
            ->join('properties', 'properties.id', 'semana_propiedad.id_propiedad')
            ->join('provincias', 'provincias.id', 'properties.province')
            ->join('localidades', 'localidades.id', 'properties.city')
            ->select('semana_propiedad.*', 'semana_propiedad.id AS id_sp', 'properties.*', 'provincias.*', 'localidades.*', 'semana.fecha_inicio', 'semana.fecha_cierre')
            ->get();

        return view('profile', ['user' => $user, 'user_solicitudes' => $solicitudes, 'userFavoritos' => $userFavoritos, 'userReservas' => $userReservas, 'userSubastas' => $userSubastas]);

        //$provincias = DB::table('provincias')
            //->select('nombre_provincia', 'id')
            //->orderByRaw('nombre_provincia ASC')
            //->get();

        //$localidades = DB::table('localidades')
            //->select('nombre_localidad', 'id', 'id_provincia')
            //->orderByRaw('nombre_localidad ASC')
            //->get();

        //return view('home', ['provincias' => $provincias], ['localidades' => $localidades]);
    }
}
