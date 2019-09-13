<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\Http\Controllers\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use DateTime;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'address' => 'required',
            'city' => 'required',
            'provincia' => 'required',
            'country' => 'required',
            //'price' => 'required'
        ]);
        
        $propiedades_nuevas = DB::table('properties')
            ->where([
                ['city', '=', $request->city],
                ['title', '=', $request->title],
            ])->get();


        if (count($propiedades_nuevas) > 0) {

            return redirect()->back()->with('error', 'Ya existe una propiedad con ese nombre en esa localidad.')->withInput();
        
        }
        else {
            $property = new Property([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'address' => $request->get('address'),
                'city' => $request->get('city'),
                'province' => $request->get('provincia'),
                'country' => $request->get('country'),
                'price' => 0,//$request->get('price'),
            ]);


            //Hacer un for (Pasa que no lo pude hacer andar al $property->img.$i)
            if ($request->hasFile('image1')){
                $request->file('image1');
                $aux = Storage::putFile('public/property',$request->file('image1'));
                $property->img1 = substr($aux, 16);
            }
            if ($request->hasFile('image2')){
                $request->file('image2');
                $aux = Storage::putFile('public/property',$request->file('image2'));
                $property->img2 = substr($aux, 16); 
            }
            if ($request->hasFile('image3')){
                $request->file('image3');
                $aux = Storage::putFile('public/property',$request->file('image3'));
                $property->img3 = substr($aux, 16); 
            }
            if ($request->hasFile('image4')){
                $request->file('image4');
                $aux = Storage::putFile('public/property',$request->file('image4'));
                $property->img4 = substr($aux, 16); 
            }
            if ($request->hasFile('image5')){
                $request->file('image5');
                $aux = Storage::putFile('public/property',$request->file('image5'));
                $property->img5 = substr($aux, 16); 
            }
            
            $property->save();

            return redirect()->back()->with('success', 'La propiedad se ha cargado con éxito');

        }
    }
    
    public function showModify($id)
    {
        $property = DB::table('properties')->where('id', $id)->get();

        $reservas = DB::table('reservas')->where('property_id', $id)->get();

        return view('modify_property', ['property' => $property], ['reservas' => $reservas]);
    }

    public function generarSemana(Request $request)
    {
        $code = 2;
        session(['codigo' => $code]);

        $this->validate($request, [
            'property_id' => 'required',
            'semana_id' => 'required',
            'precio_base' => 'required'
        ]);

        $existe = DB::table('semana_propiedad')
            ->where([
                ['id_semana', '=', $request->semana_id],
                ['id_propiedad', '=', $request->property_id]
            ])
            ->get();

        if (count($existe) > 0 ){
            return redirect()->back()->with('error', 'Ya existe esa semana para esa propiedad');    
        }
        else {
            
            $semana_query = DB::table('semana')
            ->where([
                ['id', '=', $request->semana_id]
            ])
            ->get();

            $tipo = 0;
            $fecha_semana = new DateTime($semana_query->first()->fecha_inicio);

            $diff = $fecha_semana->diff($this->getHoy())->format("%a");

            $active = 0;
            if ($diff < 161) { //161 = 23 X 7 (5meses 3 semanas)
                $tipo = 3; //Hotsale
            } else if ($diff > 180) {
                $tipo = 1; //Alquiler directo
                $active = 1;
            }
            else {
                $tipo = 2; //Subasta
            }

            DB::table('semana_propiedad')->insert([[
                'id_semana' => $request->semana_id,
                'id_propiedad' => $request->property_id,
                'precio_base' => $request->precio_base,
                'disponible' => 1,
                'esta_activo' => $active,
                'tipo' => $tipo],
            ]);

            return redirect()->back()->with('success', 'La semana se ha generado con éxito');
        }
    }

    public function openHotsale(Request $request)
    {
    
        $code = 5;
        session(['codigo' => $code]);

        $this->validate($request, [
            'id_sp' => 'required',
            'nuevo_monto' => 'required',
        ]);

        //Hotsale Opening
        DB::table('hotsale')->insert(
            ['id_sp' => $request->id_sp, 'nuevo_monto' => $request->nuevo_monto]
        );
        DB::table('semana_propiedad')
            ->where('id', $request->id_sp)    
            ->update(
            ['id_usuario' => 0, 'esta_activo' => 1]
        );

        //User notification
        $userFavoritos = DB::table('favoritos')
            ->where('favoritos.id_sp', $request->id_sp)
            ->join('semana_propiedad', 'semana_propiedad.id', 'favoritos.id_sp')
            ->join('semana', 'semana_propiedad.id_semana', 'semana.id')
            ->join('properties', 'properties.id', 'semana_propiedad.id_propiedad')
            ->join('provincias', 'provincias.id', 'properties.province')
            ->join('localidades', 'localidades.id', 'properties.city')
            ->join('users', 'users.id', 'favoritos.id_usuario')
            ->select('favoritos.*', 'favoritos.id AS favid', 'semana_propiedad.*', 'semana_propiedad.id AS spid', 'semana.*', 'properties.*', 'provincias.*', 'localidades.*', 'users.*')
            ->get();

        if (count($userFavoritos) > 0) {
            foreach ($userFavoritos as $user) {
                
                $email_content = 'Para: '.$user->email.' '.'Se le comunica que la propiedad: '.$user->title.', '.$user->nombre_localidad.', '.$user->nombre_provincia.', para la semana: '.$user->fecha_inicio.' / '.$user->fecha_cierre.', ya se encuentra disponible para alquilar por HotSale!';
                Storage::put('/public/emails/Disponibilidad_de_Hotsale_para_'.$user->email.'.txt', $email_content);

            }
        }


        return redirect()->back()->with('success', 'El hotsale se ha generado con éxito');
    }

    public function closeHotsale(Request $request)
    {

        $code = 6;
        session(['codigo' => $code]);

        $this->validate($request, [
            'id_hotsale' => 'required',
        ]);

        $sp_query = DB::table('hotsale')
            ->where('id', '=', $request->id_hotsale)
            ->get();

        DB::table('semana_propiedad')
            ->where('id', $sp_query->first()->id_sp)    
            ->update(
            ['esta_activo' => 0]
        );

        DB::table('hotsale')->where('id', '=', $request->id_hotsale)->delete();

        return redirect()->back()->with('success', 'El hotsale se ha cerrado con éxito');
    }

    public function ingresarHotsale(Request $request)
    {
        $this->validate($request, [
            'id_hotsale' => 'required',
        ]);

        $sp_query = DB::table('hotsale')
            ->where('id', '=', $request->id_hotsale)
            ->get();

        DB::table('semana_propiedad')
            ->where('id', $sp_query->id_sp)    
            ->update(
            ['esta_activo' => 0]
        );

        DB::table('hotsale')->where('id', '=', $request->id_hotsale)->delete();

        return redirect()->back()->with('success', 'El hotsale se ha cerrado con éxito');
    }

    public function addFavorito(Request $request) {

        if ($request->add_value) {
            DB::table('favoritos')->insert(['id_sp' => $request->id_sp, 'id_usuario' => $request->id_user]);
            
            return redirect()->back()->with('success', 'Has agregado el tiempo compartido a tu lista de favoritos');
        }
        else {
            DB::table('favoritos')->where([
                ['id_sp', '=', $request->id_sp],
                ['id_usuario', '=', $request->id_user],
            ])->delete();

            return redirect()->back()->with('success', 'Has eliminado el tiempo compartido de lista de favoritos');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
