<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuscripcionController extends Controller
{

    public function store(Request $request)
    {
        $code = 2;
        session(['codigo' => $code]);

        $this->validate($request, [
            'user_id' => 'required',
            'value' => 'required'
        ]);

        DB::table('solicitudes')->insert(
            ['user_id' => $request->user_id , 'type' => $request->value , 'descripcion' => $request->descripcion ]
        );

        return redirect()->back()->with('success', 'La solicitud se ha cargado con éxito');
    }

    public function changeStatus(Request $request)
    {
        $code = 3;
        session(['codigo' => $code]);

        $this->validate($request, [
            'user_id' => 'required',
            'solicitud_id' => 'required', //ID de solicitud
            'type' => 'required'
        ]);

        //Cambiar estado de usuario
        DB::table('users')
            ->where('id', $request->user_id)
            ->update([
                'premium' => $request->type
        ]);

        //Cambiar estado de solicitud
        DB::table('solicitudes')
            ->where('id', $request->solicitud_id)
            ->update([
                'status' => 0
            ]);

        return redirect()->back()->with('success', 'La solicitud se ha cargado con éxito');
    }    
}
