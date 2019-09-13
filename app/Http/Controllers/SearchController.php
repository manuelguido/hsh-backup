<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use DateTime;

class SearchController extends Controller
{

    public function getHoy(){

        DB::table('get_hoy')->insert([
            ['name' => 1]
        ]);
        $hoy_query = DB::table('get_hoy')
            ->where('name', '=', 1)
            ->get();

        DB::table('get_hoy')->delete();

        $hoy = new DateTime($hoy_query->first()->hoy);
        return $hoy;
    }

    public function makeSearchajsdjkashjjdhaskljdhasjkhdjksah(Request $request) {
        
        $this->validate($request, [
            'desde' => 'required',
            'hasta' => 'required',
            'ciudad' => 'required',
            'tomar_ubicacion' => 'required',
        ]);

        $desde = new DateTime($request->desde);
        $hasta = new DateTime($request->hasta);
        $diff = $hasta->diff($desde)->format("%a");

        if ($diff > 56) {
            return redirect()->back()->with('error', 'El lapso de tiempo entre dos fechas no puede superar 8 semanas (dos meses)')->withInput();
        }

        if ($request->tomar_ubicacion == 1) {
            if (!Auth::user()->premium) {
                $properties = DB::table('properties')
                ->where([
                    ['available', '=', '1'],
                    ['id_usuario', '=', '0'],
                    ['tipo', '<>', '1'],
                    ['fecha_inicio', '>=', $request->desde],
                    ['fecha_cierre', '<=', $request->hasta],
                    ['properties.city', '=', $request->ciudad],
                ])
                ->join('provincias', 'properties.province', '=', 'provincias.id')
                ->join('localidades', 'properties.city', '=', 'localidades.id')
                ->join('semana_propiedad', 'properties.id', '=', 'semana_propiedad.id_propiedad')
                ->select('properties.*', 'provincias.nombre_provincia', 'localidades.nombre_localidad')
                ->distinct()
                ->get();
            }
            else {
                $properties = DB::table('semana_propiedad')
                ->where([
                    ['available', '=', '1'],
                    ['semana_propiedad.id_usuario', '=', '0'],
                    ['semana.fecha_inicio', '>=', $request->desde],
                    ['semana.fecha_cierre', '<=', $request->hasta],
                    ['localidades.id', '=', $request->ciudad],
                ])
                ->join('properties', 'properties.id', '=', 'semana_propiedad.id_propiedad')
                ->join('provincias', 'properties.province', '=', 'provincias.id')
                ->join('localidades', 'properties.city', '=', 'localidades.id')
                ->select('properties.city', 'properties.province', 'provincias.nombre_provincia', 'localidades.nombre_localidad', 'semana_propiedad.id_propiedad')
                ->groupBy('semana_propiedad.id_propiedad')
                ->distinct()
                ->get();
            }
        }
        else {
            if (!Auth::user()->premium) {
                $properties = DB::table('properties')
                ->where([
                    ['available', '=', '1'],
                    ['id_usuario', '=', '0'],
                    ['tipo', '<>', '1'],
                    ['fecha_inicio', '>=', $request->desde],
                    ['fecha_cierre', '<=', $request->hasta],
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
                    ['fecha_inicio', '>=', $request->desde],
                    ['fecha_cierre', '<=', $request->hasta],
                ])
                ->join('provincias', 'properties.province', '=', 'provincias.id')
                ->join('localidades', 'properties.city', '=', 'localidades.id')
                ->join('semana_propiedad', 'properties.id', '=', 'semana_propiedad.id_propiedad')
                ->select('properties.*', 'provincias.nombre_provincia', 'localidades.nombre_localidad')
                ->distinct()
                ->get();
        }

        return view('make_search', ['properties' => $properties]);

    }
}
}