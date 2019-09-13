<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResidenciasController extends Controller
{
    /**
     * Create a new controller instance.
     *

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $subastas = DB::table('subastas')
            ->join('properties', 'properties.id', '=', 'subastas.property_id')
            ->select('properties.*', 'subastas.initial_value', 'subastas.begin_date', 'subastas.end_date', 'subastas.id as idsubasta' )
            ->where('available', '1')
            ->where('is_closed', '0')
            ->get();

        return view('residencias', ['subastas' => $subastas]);
    }
}
