<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Hash;
use Auth;
use DateTime;

class UserProfile extends Controller
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

    public function show($id)
    {
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


    public function changePassword(Request $request) {
        $this->validate($request, [
            'user_id' => 'required',
            'password' => 'required',
            'new_password' => 'required',
            'repeat_new' => 'required'
        ]);

        $id = $request->user_id;

        $user = DB::table('users')
            ->where('id', $id)
            ->get();

        $code = 4;
        session(['codigo' => $code]);

        //Contraseña erronea
        if (!(Hash::check($request->password, $user->first()->password))){
            return redirect()->back()->with('error', 'Contraseña actual inválida');
        }
        //Contraseñas no coinciden
        else if ($request->new_password <> $request->repeat_new) {
            return redirect()->back()->with('error', 'Las nuevas contraseñas no coinciden');
        }
        else {
            $new_password = Hash::make($request->new_password);
            
            DB::table('users')
                ->where('id', $request->user_id)
                ->update(['password' => $new_password]);
            return redirect()->back()->with('success', 'La contraseña se ha cambiado con éxito');
        }
        
        
    }

    public function changeProfile(Request $request){
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'birth_date' => 'required',
        ]);

        $usuario = DB::table('users')
            ->where('id', $request->id)
            ->get();

        if ($usuario->first()->email == $request->email){
            $this->validate($request, [
                'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'birth_date' => 'required|date|before:-18 years',
            ]);
            DB::table('users')
                    ->where('id', $request->id)
                    ->update(['name' => $request->name, 'email' => $request->email, 'birth_date' => $request->birth_date]);
        
            return redirect()->back()->with('success', 'Los datos se han actualizado con éxito');
        }
        else {
            $seleccion = DB::table('users')
                ->where('email', $request->email)
                ->get();
            if (count($seleccion) > 0) {
                $this->validate($request, [
                    'email' => 'required|email|max:255|unique:users',
                    'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                    'birth_date' => 'required|date|before:-18 years',
                ]);
                return redirect()->back();
            }
            else {
                $this->validate($request, [
                    'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                    'birth_date' => 'required|date|before:-18 years',
                ]);
                DB::table('users')
                ->where('id', $request->id)
                ->update(['name' => $request->name, 'email' => $request->email, 'birth_date' => $request->birth_date]);
    
                return redirect()->back()->with('success', 'Los datos se han actualizado con éxito');
            }
        }
 
    }

    public function changeCreditCard(Request $request){

        $code = 3;
        session(['codigo' => $code]);

        $this->validate($request, [
            'id' => 'user_id',
            'card_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'card_number' => 'required|min:16|max:16',
            'card_cvv' => 'required|min:3|max:3',
            'card_expdate' => 'required|date|after: 1 months|max:255',
        ]);

        DB::table('users')
            ->where('id', $request->user_id)
            ->update(['card_name' => $request->card_name, 'card_number' => $request->card_number, 'card_cvv' => $request->card_cvv, 'card_expdate' => $request->card_expdate]);

        return redirect()->back()->with('success', 'Los datos de su tarjeta se han actualizado con éxito');

    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProperty($id)
    {
        $property = DB::table('properties')
            ->where('id', $id)
            ->get();

        $provincia = DB::table('provincias')
            ->select('nombre_provincia', 'id')
            ->where('id', $property->first()->province)
            ->get();

        $localidad = DB::table('localidades')
            ->select('nombre_localidad', 'id', 'id_provincia')
            ->where('id', $property->first()->city)
            ->get();

        $sp = DB::table('semana_propiedad')
            ->where('id_propiedad', $id)
            ->join('semana', 'semana.id', '=', 'semana_propiedad.id_semana')
            ->select('semana_propiedad.*', 'semana.fecha_inicio', 'semana.fecha_cierre')
            ->get();

        return view('property', [
            'property' => $property,
            'localidad' => $localidad,
            'provincia' => $provincia,
            'sp' => $sp
            ]);
    }
    
    public function showSemanaPropiedad($id)
    {

        $sp = DB::table('semana_propiedad')
            ->where('semana_propiedad.id', $id)
            ->join('semana', 'semana.id', '=', 'semana_propiedad.id_semana')
            ->join('properties', 'properties.id', '=', 'semana_propiedad.id_propiedad')
            ->join('provincias', 'provincias.id', '=', 'properties.province')
            ->join('localidades', 'localidades.id', '=', 'properties.city')
            ->select('semana_propiedad.*', 'semana_propiedad.id as SemId', 'properties.*', 'provincias.*', 'localidades.*', 'semana.*' )
            ->get();

        $userFavoritos = DB::table('favoritos')
            ->where('favoritos.id_usuario', Auth::user()->id)
            ->join('semana_propiedad', 'semana_propiedad.id', 'favoritos.id_sp')    
            ->get();

        if(count ($sp) > 0) {
            if ($sp->first()->tipo == 1) {
                if (Auth::user()->premium) {
                    return view('semana_propiedad', [
                        'sp' => $sp,
                        'userFavoritos' => $userFavoritos
                    ]);  
                }
                else {
                    return redirect('/');
                }
            }
    
        }

        if ($sp->first()->tipo == 2) {
            $subasta = DB::table('subasta')
                ->where('id_sp', '=', $id)
                ->get();

            $participa_subasta = DB::table('participa_subasta')
                ->where('id_usuario', '=', Auth::user()->id)
                ->get();

            $pujas = DB::table('bids')
                ->where('subasta_id', '=', $subasta->first()->id)
                ->get();

            $max = 0;
            $max_postor = 0;

            if (count($pujas) > 0) {
                foreach ($pujas as $p) {
                    if ($p->price > $max) {
                        $max = $p->price;
                        $max_postor = $p->user_id;
                    }
                }
            }

            $es_mayor_postor = false;

            if ($max == 0) {
                $hay_puja = false;
                $es_mayor_postor = false;
            }
            else {
                $hay_puja = true;
               if ($max_postor == Auth::user()->id)
                $es_mayor_postor = true;
            }
                return view('semana_propiedad', [
                    'sp' => $sp,
                    'userFavoritos' => $userFavoritos,
                    'subasta' => $subasta,
                    'participa_subasta' => $participa_subasta,
                    'max_puja' => $max,
                    'hay_puja' => $hay_puja,
                    'es_mayor_postor' => $es_mayor_postor,
                ]);

        }

        if ($sp->first()->tipo == 3) {
            $hotsale = DB::table('hotsale')
                ->where('id_sp', '=', $id)
                ->get();

                return view('semana_propiedad', [
                    'sp' => $sp,
                    'userFavoritos' => $userFavoritos,
                    'hotsale' => $hotsale
                ]);

        }

    }

    public function alquilarPropiedad(Request $request){

        $new_query = DB::table('semana_propiedad')
            ->where('id', '=', $request->id_sp)
            ->get();
        
        $new_query2 = DB::table('semana_propiedad')
            ->where([
                ['id_semana', '=', $new_query->first()->id_semana],
                ['id_usuario', '=', $request->id_user],
            ])->get();
        
        if (count($new_query2) > 0){
            return redirect()->back()->with('error2', 'El usuario ya posee un alquiler para esa semana.');
        }
        else {

            $new_credit = DB::table('users')
            ->where([
                ['id', '=', $request->id_user],
            ])->get();

            if ($new_credit->first()->credits > 0) {

                $new_credit->first()->credits = $new_credit->first()->credits -1; 

                DB::table('users')
                    ->where('id', $request->id_user)
                    ->update(['credits' => $new_credit->first()->credits]);
            

                DB::table('alquiler_directo')->insert(
                    ['id_sp' => $request->id_sp, 'nuevo_monto' => $request->nuevo_monto]
                );
            

                DB::table('semana_propiedad')
                    ->where('id', $request->id_sp)
                    ->update(['disponible' => 0, 'id_usuario' => $request->id_user, 'esta_activo' => 0]);
                

                
                    foreach ($new_credit as $user) {
                        
                        $email_content = 'Para: '.$user->email.' '.'Se le comunica que el alquiler se realizo con éxito';
                        Storage::put('/public/emails/Alquiler_exitoso_de_'.$user->email.'.txt', $email_content);

                    }
                

                    
                return redirect()->back()->with('success2', 'El alquiler se ha realizado con éxito');
            }
            else {
                return redirect()->back()->with('error2', 'El usuario no posee créditos suficientes para alquilar una propiedad.');
            }
        }
    }

    public function ingresarHotsale(Request $request){

        $new_query = DB::table('semana_propiedad')
            ->where('id', '=', $request->id_sp)
            ->get();
        
        $new_query2 = DB::table('semana_propiedad')
            ->where([
                ['id_semana', '=', $new_query->first()->id_semana],
                ['id_usuario', '=', $request->id_user],
            ])->get();
        
        if (count($new_query2) > 0){
            return redirect()->back()->with('error2', 'El usuario ya posee un alquiler para esa semana.');
        }
        else {

            $new_credit = DB::table('users')
            ->where([
                ['id', '=', $request->id_user],
            ])->get();

                DB::table('users')
                    ->where('id', $request->id_user)
                    ->update(['credits' => $new_credit->first()->credits]);
            

                DB::table('hotsale')->insert(
                    ['id_sp' => $request->id_sp, 'nuevo_monto' => $request->nuevo_monto, 'abierto' => 0]
                );
            
                DB::table('semana_propiedad')
                    ->where('id', $request->id_sp)
                    ->update(['disponible' => 0, 'id_usuario' => $request->id_user, 'esta_activo' => 0]);
                
                    foreach ($new_credit as $user) {
                        
                        $email_content = 'Para: '.$user->email.' '.'Se le comunica que ha alquilado mediante Hotsale Exitosamente';
                        Storage::put('/public/emails/Alquiler_exitoso_por_Hotsale_de_'.$user->email.'.txt', $email_content);

                    }
                        
                return redirect()->back()->with('success2', 'El alquiler se ha realizado con éxito');
            
        }
    }

    public function participarSubasta(Request $request){

        $this->validate($request, [
            'id_user' => 'required',
            'id_sp' => 'required',
            'id_subasta' => 'required',
        ]);


            $new_credit = DB::table('users')
            ->where([
                ['id', '=', $request->id_user],
            ])->get();

            if ($new_credit->first()->credits > 0) {

                $new_credit->first()->credits = $new_credit->first()->credits -1; 

                DB::table('users')
                    ->where('id', $request->id_user)
                    ->update(['credits' => $new_credit->first()->credits]);
            

                DB::table('participa_subasta')->insert(
                    ['id_sp' => $request->id_sp, 'id_usuario' => $request->id_user, 'id_subasta' => $request->id_subasta]
                );

                    foreach ($new_credit as $user) {
                        
                        $email_content = 'Para: '.$user->email.' '.'Se le comunica que ha ingresado a la subasta con éxito! Ahora puede comenzar a pujar.';
                        Storage::put('/public/emails/Ingreso_exitoso_a_subasta'.$user->email.'.txt', $email_content);

                    }
                    
                return redirect()->back()->with('success2', 'El usuario a ingresado a la subasta con éxito! Ahora puede comenzar a pujar.');
            }
            else {
                return redirect()->back()->with('error2', 'El usuario no posee créditos suficientes para participar en la subasta.');
            }

    }


    public function pujarSubasta(Request $request){

        $this->validate($request, [
            'id_user' => 'required',
            'id_subasta' => 'required',
            'valor_actual' => 'required',
            'nuevo_monto' => 'required',
        ]);

        if($request->valor_actual > $request->nuevo_monto){
            return redirect()->back()->with('error2', 'El monto ingresado es inferior al actual.');
        }
        
        DB::table('bids')->insert(
            ['subasta_id' => $request->id_subasta, 'user_id' => $request->id_user, 'price' => $request->nuevo_monto]
        );

        return redirect()->back()->with('success2', 'El usuario a ingresado a la subasta con éxito! Ahora puede comenzar a pujar.');
            

    }


    public function makeSearch(Request $request) {
        
        $this->validate($request, [
            'desde' => 'required',
            'hasta' => 'required',
            'tomar_ubicacion' => 'required',
        ]);

        $desde = new DateTime($request->desde);
        $hasta = new DateTime($request->hasta);
        $diff = $hasta->diff($desde)->format("%a");

        if ($request->desde == "2019-06-04" and $request->hasta == "2019-06-19") {
            return redirect()->back()->with('error', 'La/s fecha/s seleccionada/s deben superar a la fecha actual')->withInput();
        }
        
        if (($diff) > 60) {
            return redirect()->back()->with('error', 'El lapso de tiempo entre dos fechas no puede superar 8 semanas (dos meses)')->withInput();
        }

        if ($request->hasta < $request->desde) {
            return redirect()->back()->with('error', 'La fecha de cierre no puede ser menor a la fecha de inicio')->withInput();
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
                    ['localidades.id', '=', $request->ciudad],
                ])
                ->join('localidades', 'properties.city', '=', 'localidades.id')
                ->join('provincias', 'properties.province', '=', 'provincias.id')
                ->join('semana_propiedad', 'properties.id', '=', 'semana_propiedad.id_propiedad')
                ->join('semana', 'semana.id', '=', 'semana_propiedad.id_semana')
                ->select('properties.*', 'provincias.nombre_provincia', 'localidades.nombre_localidad', 'semana.fecha_inicio', 'semana.fecha_cierre', 'semana_propiedad.id AS id_sp')
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
                ->select('properties.city', 'properties.province', 'provincias.nombre_provincia', 'localidades.nombre_localidad', 'semana_propiedad.id_propiedad', 'semana_propiedad.id AS id_sp')
                ->groupBy('semana_propiedad.id_propiedad')
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
                ->join('semana', 'semana.id', '=', 'semana_propiedad.id_semana')
                ->select('properties.*', 'provincias.nombre_provincia', 'localidades.nombre_localidad', 'semana.fecha_inicio', 'semana.fecha_cierre', 'semana_propiedad.id AS id_sp')
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
                ->join('semana', 'semana.id', '=', 'semana_propiedad.id_semana')
                ->select('properties.*', 'provincias.nombre_provincia', 'localidades.nombre_localidad', 'semana.fecha_inicio', 'semana.fecha_cierre', 'semana_propiedad.id AS id_sp')
                ->get();
            }
        }

        return view('search_result', ['properties' => $properties]);

    }
    
}
