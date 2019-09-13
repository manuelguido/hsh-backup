<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Property;
use App\Http\Controllers\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Hash;
use DateTime;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Semanas para abrir
        $semana = DB::table('semana')
            ->orderByRaw('id ASC')
            ->get();
            
        //Semanas concretas para una propiedad
        $semana_propiedad = DB::table('semana_propiedad')
            ->select('semana_propiedad.*', 'id_semana', 'id_propiedad', 'fecha_inicio', 'fecha_cierre', 'properties.title', 'properties.city', 'properties.province', 'properties.address', 'provincias.nombre_provincia', 'localidades.nombre_localidad')    
            ->join('semana', 'semana_propiedad.id_semana', '=', 'semana.id')
            ->join('properties', 'semana_propiedad.id_propiedad', '=', 'properties.id')
            ->join('provincias', 'properties.province', '=', 'provincias.id')
            ->join('localidades', 'properties.city', '=', 'localidades.id')
            ->get();

        $solicitudes = DB::table('solicitudes')
            ->select('users.id as user_id', 'name', 'email', 'premium', 'solicitudes.id', 'descripcion','type')    
            ->where('status', 1)
            ->join('users', 'users.id', '=', 'solicitudes.user_id')
            ->get();

        $provincias = DB::table('provincias')
            ->select('nombre_provincia', 'id')
            ->orderByRaw('nombre_provincia ASC')
            ->get();

        $localidades = DB::table('localidades')
            ->select('nombre_localidad', 'id', 'id_provincia')
            ->orderByRaw('nombre_localidad ASC')
            ->get();
        
        $properties = DB::table('properties')
            ->join('provincias', 'properties.province', '=', 'provincias.id')
            ->join('localidades', 'properties.city', '=', 'localidades.id')
            ->select('properties.*', 'provincias.nombre_provincia', 'localidades.nombre_localidad')
            ->get();

        $subastas = DB::table('subasta')
            ->where('semana_propiedad.disponible', '=' , 1)
            ->join('semana_propiedad', 'semana_propiedad.id', '=', 'subasta.id_sp')
            ->join('properties', 'properties.id', '=', 'semana_propiedad.id_propiedad')
            ->join('provincias', 'properties.province', '=', 'provincias.id')
            ->join('localidades', 'properties.city', '=', 'localidades.id')
            ->select('subasta.*', 'properties.title', 'properties.address', 'properties.city', 'properties.province', 'properties.country', 'properties.img1','provincias.nombre_provincia', 'localidades.nombre_localidad', 'semana_propiedad.esta_activo')
            ->get();

        $hotsales = DB::table('hotsale')
            ->where('semana_propiedad.disponible', '=' , 1)
            ->join('semana_propiedad', 'semana_propiedad.id', '=', 'hotsale.id_sp')
            ->join('properties', 'properties.id', '=', 'semana_propiedad.id_propiedad')
            ->join('semana', 'semana.id', '=', 'semana_propiedad.id_semana')
            ->join('provincias', 'properties.province', '=', 'provincias.id')
            ->join('localidades', 'properties.city', '=', 'localidades.id')
            ->select('hotsale.*', 'semana_propiedad.esta_activo', 'properties.title', 'properties.address', 'properties.city', 'properties.province', 'properties.country', 'properties.img1','semana.fecha_inicio', 'semana.fecha_cierre','provincias.nombre_provincia', 'localidades.nombre_localidad')
            ->get();

        $alquileres = DB::table('alquiler_directo')
            ->where('semana_propiedad.disponible', '=' , 1)
            ->join('semana_propiedad', 'semana_propiedad.id', '=', 'alquiler_directo.id_sp')
            ->join('properties', 'properties.id', '=', 'semana_propiedad.id_propiedad')
            ->join('semana', 'semana.id', '=', 'semana_propiedad.id_semana')
            ->join('provincias', 'properties.province', '=', 'provincias.id')
            ->join('localidades', 'properties.city', '=', 'localidades.id')
            ->select('alquiler_directo.*', 'properties.title', 'properties.address', 'properties.city', 'properties.province', 'properties.country', 'properties.img1','semana.fecha_inicio', 'semana.fecha_cierre','provincias.nombre_provincia', 'localidades.nombre_localidad')
            ->get();

        $userReservas = DB::table('semana_propiedad')
            ->where('semana_propiedad.id_usuario', '<>', '0')
            ->join('users', 'semana_propiedad.id_usuario', 'users.id')
            ->join('semana', 'semana_propiedad.id_semana', 'semana.id')
            ->join('properties', 'properties.id', 'semana_propiedad.id_propiedad')
            ->join('provincias', 'provincias.id', 'properties.province')
            ->join('localidades', 'localidades.id', 'properties.city')
            ->select('semana_propiedad.*', 'semana_propiedad.id AS id_sp', 'properties.*', 'provincias.*', 'localidades.*', 'semana.fecha_inicio', 'semana.fecha_cierre', 'users.name', 'users.email')
            ->get();

        //Valor de suscripcion
        $valor_suscripcion = DB::table('valor_suscripcion')
            ->get();

        //Listado de usuarios
        $userslist = DB::table('users')
            ->orderByRaw('name ASC')    
            ->get();

        $adminslist = DB::table('admins')
            ->orderByRaw('name ASC')    
            ->get();
        
        //$valor_suscripcion = DB::table('valor_suscripcion')->get();
        //$cobros = DB::table('cobros')->get();
        //$cobros_usuarios = DB::table('cobros')
        //    ->join('users', 'users.id', '=', 'cobros.id_usuario')
        //    ->get();

        //$reservas = DB::table('reservas')
        //    ->join('properties', 'properties.id', '=', 'reservas.property_id')
        //    ->join('subastas', 'subastas.id', '=', 'reservas.subasta_id')
        //    ->join('bids', 'subastas.id', '=', 'reservas.subasta_id')
        //    ->get();


        //BOOLEANOS PARA FOREACHS
        $posible_subasta_query = DB::table('semana_propiedad')
            ->where([
                ['tipo', 2],
                ['esta_activo', 0],
            ])
            ->count();

        if ($posible_subasta_query > 0) {
            $posible_subasta = true;
        }
        else {
            $posible_subasta = false;
        }

        $posible_hotsale_query = DB::table('semana_propiedad')
                ->where([
                    ['tipo', 3],
                    ['esta_activo', 0],
                ])
                ->count();

        if ($posible_hotsale_query > 0) {
            $posible_hotsale = true;
        }
        else {
            $posible_hotsale = false;
        }

        return view('admin', [
            'solicitudes' => $solicitudes ,
            'subastas' => $subastas ,
            'provincias' => $provincias ,
            'properties' => $properties ,
            'localidades' => $localidades,
            //'reservas' => $reservas,
            'semana' => $semana,
            'semana_propiedad' => $semana_propiedad,
            //'valor_suscripcion' => $valor_suscripcion,
            //'cobros' => $cobros,
            //'cobros_usuarios' => $cobros_usuarios,
            'hotsales' => $hotsales,
            'alquileres' => $alquileres,
            'subastas' => $subastas,
            'userReservas' => $userReservas,
            //'abrir_hotsales' => $abrir_hotsales,
            'posible_subasta' => $posible_subasta,
            'posible_hotsale' => $posible_hotsale,
            'valor_suscripcion' => $valor_suscripcion,
            'userslist' => $userslist,
            'adminslist' => $adminslist
        ]);

    }

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

    public function changeValoresSuscripcion(Request $request) {
        $code = 12;
        session(['codigo' => $code]);

        $this->validate($request, [
            'valor_basico' => 'required',
            'valor_premium' => 'required'
        ]);

        if ($request->valor_basico == 0){
            return redirect()->back()->withInput()->with('valor_suscripcion_basica_cero', 'Valores');    
        }

        if ($request->valor_premium == 0){
            return redirect()->back()->withInput()->with('valor_suscripcion_premium_cero', 'Valores');    
        }

        if ($request->valor_basico >= $request->valor_premium){
            return redirect()->back()->withInput()->with('valor_premium_menor', 'El valor de suscripción premium debe ser mayor que el de suscripción básica');    
        }

        DB::table('valor_suscripcion')
            ->where('id', 1)
            ->update(['valor_premium' => $request->valor_premium, 'valor_basico' => $request->valor_basico]);

        return redirect()->back()->with('success', 'El valor de las suscripciones se ha actualizado con éxito');

    }

    public function dropUser(Request $request) {
        
        
        if ($request->tipo == 'users'){
            $code = 9;
        }
        else {
            $code = 10;
        }
        
        session(['codigo' => $code]);

        $this->validate($request, [
            'id' => 'required',
            'tipo' => 'required'
        ]);

        if ($request->tipo == 'users') {

            //Liberar semanas
            $semana_existe = DB::table('semana_propiedad')
                ->where([['semana_propiedad.id_usuario', '=', $request->id],])
                ->join('semana', 'semana.id', 'semana_propiedad.id_semana')
                ->select('semana_propiedad.*', 'semana.fecha_inicio', 'semana.fecha_cierre')
                ->get();

            if (count($semana_existe) > 0) {

                foreach ($semana_existe as $e) {
                    
                    if ($e->tipo == 1) {
                        DB::table('alquiler')
                        ->where('id_sp', $e->id)
                        ->delete();
                    }
                    else if ($e->tipo == 2){
                        DB::table('subasta')
                        ->where('id_sp', $e->id)
                        ->delete();
                    }
                    else {
                        DB::table('hotsale')
                        ->where('id_sp', $e->id)
                        ->delete();
                    }

                    $fecha_semana = new DateTime($e->fecha_inicio);
                    $diff = $fecha_semana->diff($this->getHoy())->format("%a");

                    if ($diff < 180) { //161 = 23 X 7 (5meses 3 semanas)
                        $e->tipo = 3; //Hotsale
                    } else {
                        $e->tipo = 1; //Alquiler directo
                    }

                    DB::table('semana_propiedad')
                        ->where('id', $e->id)
                        ->update(['disponible' => 1, 'id_usuario' => 0, 'esta_activo' => 0, 'tipo' => $e->tipo]);

                }
            }
        }

        DB::table($request->tipo)->where('id', '=', $request->id)->delete();

        $add = '';

        if ($request->tipo == 'admins') {
            $add= "administrador ";
        }

        return redirect()->back()->with('success', 'El usuario '.$add.'se ha eliminado con éxito');

    }

    public function newAdmin(Request $request) {
        
        $code = 11;
        session(['codigo' => $code]);

        $this->validate($request, [
            'name_admin' => 'required',
            'email_admin' => 'required',
            'admin_password' => 'required',
        ]);

        $admin = DB::table('admins')
            ->where('email', $request->email_admin)
            ->get();


        if (count($admin) > 0){
            return redirect()->back()->withInput()->with('error_admin_email', 'El email ya existe en la base de datos de administradores');
        }

        $password = Hash::make($request->admin_password);

        DB::table('admins')->insert(
            ['name' => $request->name_admin, 'email' => $request->email_admin, 'password' => $password]
        );

        return redirect()->back()->with('success', 'El nuevo administrador se ha creado con éxito');

    }

    public function showModify($id)
    {
        $property = DB::table('properties')->where('id', $id)->get();

        $reservas = DB::table('reservas')->where('property_id', $id)->get();

        $provincias = DB::table('provincias')
            ->select('nombre_provincia', 'id')
            ->orderByRaw('nombre_provincia ASC')
            ->get();

        $localidades = DB::table('localidades')
            ->select('nombre_localidad', 'id', 'id_provincia')
            ->orderByRaw('nombre_localidad ASC')
            ->get();

        return view('modify_property', [
            'property' => $property ,
            'reservas' => $reservas,
            'provincias' => $provincias,
            'localidades' => $localidades
            ]);
    }


    public function modifySend(Request $request)
    {
      
        try {
            $this->validate($request, [
                'title' => 'required',
                'description' => 'required',
                'address' => 'required',
                'city' => 'required',
                'province' => 'required',
                'country' => 'required',
                'price' => 'required',
                'image1',
                'image2',
                'image3',
                'image4',
                'image5',
                'eliminar2',
                'eliminar3',
                'eliminar4',
                'eliminar5'
            ]);   
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Debes completar todos los campos de información', 'campos', $property);
        }

            $property = [
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'address' => $request->get('address'),
                'city' => $request->get('city'),
                'province' => $request->get('province'),
                'country' => $request->get('country'),
                'price' => $request->get('price'),
            ];

            if ($request->hasFile('image1')){
                $request->file('image1');
                $aux = Storage::putFile('public/property',$request->file('image1'));
                $property['img1'] = substr($aux, 16);
            }
            if ($request->hasFile('image2')){
                $request->file('image2');
                $aux = Storage::putFile('public/property',$request->file('image2'));
                $property['img2'] = substr($aux, 16);
            }
            else if ($request->eliminar2 == 1){
                $property['img2'] = NULL;
            }
            if ($request->hasFile('image3')){
                $request->file('image3');
                $aux = Storage::putFile('public/property',$request->file('image3'));
                $property['img3'] = substr($aux, 16);
            }
            else if ($request->eliminar3 == 1){
                $property['img3'] = NULL;
            }
            if ($request->hasFile('image4')){
                $request->file('image4');
                $aux = Storage::putFile('public/property',$request->file('image4'));
                $property['img4'] = substr($aux, 16);
            }
            else if ($request->eliminar4 == 1){
                $property['img4'] = NULL;
            }
            if ($request->hasFile('image5')){
                $request->file('image5');
                $aux = Storage::putFile('public/property',$request->file('image5'));
                $property['img5'] = substr($aux, 16);
            }
            else if ($request->eliminar5 == 1){
                $property['img5'] = NULL;
            }

            DB::table('properties')->where('id', $request->id)
                ->update($property);

            return redirect()->back()->with('success', 'La propiedad se ha actualizado con éxito');

    }

    public function cobrarSuscripcion (Request $request) {
        $code = 4;
        session(['codigo' => $code]);

        $this->validate($request, [
            'valor_premium' => 'required',
            'valor_basico' => 'required'
        ]);

        $users = DB::table('users')->get();

        foreach ($users as $user) {
            if ($user->premium) {
                $valor = $request->valor_premium;
            } else {
                $valor = $request->valor_basico;
            } 
            DB::table('cobros')->insert([
                ['id_usuario' => $user->id, 'valor' => $valor, 'is_premium' => $user->premium, 'fecha' => '2019-06-19'],
            ]);
        }

        return redirect()->back()->with('success', 'Se ha realizado el cobro mensual con éxito');
    }
    
    public function deleteDB() {
        DB::table('properties')->delete();
        return redirect()->back();
    }
    
}