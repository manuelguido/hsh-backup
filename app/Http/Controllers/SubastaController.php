<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subasta;
use App\Bid;
use App\Http\Controllers\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class SubastaController extends Controller
{
    /**
     * Display a listing of the resource.
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
            'property_id',
            'begin_date',
            'end_date',
            'open_date',
            'close_date',
            'initial_value',
            'check_sunday',
            'check_sunday2',
        ]);

        $today = Carbon::now()->toDateTimeString('Y-m-d');

        if ($request->begin_date < $today) {
            return redirect()->back()->with('error', 'La fecha para esa semana de alquiler ya pasó');
        }

        if($request->check_sunday == 'Sunday' && $request->check_sunday2 == 'Sunday'){

            if ($request->begin_date > $request->open_date) {

                $subastas_existentes = DB::table('subastas')
                    ->where('property_id', '=', $request->get('property_id'))
                    ->whereDate('begin_date', '=', $request->get('begin_date'))
                    ->whereDate('end_date', '=', $request->get('end_date'))
                    ->get();

                if(count($subastas_existentes) == 0){
                    $subasta = new Subasta([
                        'property_id' => $request->get('property_id'),
                        'begin_date' => $request->get('begin_date'),
                        'end_date' => $request->get('end_date'),
                        'open_date' => $request->get('open_date'),
                        'close_date' => $request->get('close_date'),
                        'initial_value' => $request->get('initial_value')
                    ]);

                    $subasta->save();

                    return redirect()->back()->with('success', 'La subasta se ha cargado con éxito');
                }
                else {
                    return redirect()->back()->with('error', 'Ya existe una subasta para esa propiedad y esa semana');
                }
            }
            else {
                return redirect()->back()->with('error', 'La fecha de subasta no puede ser posterior a la fecha de alquiler');
            }
        }
        else {
            return redirect()->back()->with('error', 'El día de inicio de una subasta y de apertura debe ser domingo');
        }


        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subasta = DB::table('subastas')
            ->where('subastas.id', $id)
            ->join('properties', 'properties.id', '=', 'subastas.property_id')
            ->select('subastas.*', 'properties.id as property_id', 'properties.title', 'properties.description', 'properties.address', 'properties.city', 'properties.province', 'properties.country', 'properties.img1', 'properties.img2', 'properties.img3', 'properties.img4', 'properties.img5')
            ->get();

        $id2 = '12';

        $current = DB::table('bids')
            ->where('subasta_id', $id2)
            ->max('price');

        if (!empty($current)) {
            foreach($subasta as $sub){
                    $sub->initial_value = '1000';
            }
            unset($sub);
        }

        return view('subasta', ['property' => $subasta]);
    }

    public function openSubasta(Request $request)
    {
        $this->validate($request, [
            'id_sp' => 'required',
            'nuevo_monto' => 'required',
        ]);

        //Hotsale Opening
        DB::table('subasta')->insert(
            ['id_sp' => $request->id_sp, 'nuevo_monto' => $request->nuevo_monto, 'abierto' => 1]
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
                
                $email_content = 'Para: '.$user->email.' '.'Se le comunica que la propiedad: '.$user->title.', '.$user->nombre_localidad.', '.$user->nombre_provincia.', para la semana: '.$user->fecha_inicio.' / '.$user->fecha_cierre.', ya se encuentra disponible para alquilar por Subasta!';
                Storage::put('/public/emails/Disponibilidad_de_Subasta_para_'.$user->email.'.txt', $email_content);

            }
        }




        return redirect()->back()->with('success', 'La subasta se ha abierto con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function closeSubasta(Request $request)
    {   //Modificar NO FUNCIONA
        $this->validate($request, [
            'id' => 'required',
        ]);
        DB::table('subastas')->where('id', $request->id)->update(['is_closed' => '1']);
        
        return redirect()->back()->with('success', 'La subasta se ha cerrado con éxito');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logic_drop(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        DB::table('properties')->where('id', $request->id)->update(['available' => '0']);
        
        return redirect()->back()->with('success', 'La propiedad se ha dado de baja con éxito');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $today = Carbon::now()->toDateTimeString('Y-m-d');

        $subastas = DB::table('subastas')->where('property_id', '=', $request->id)->get();

        $cuenta = 0;
        
        foreach ($subastas as $s => $ss) {
            if ($ss->is_closed == 0) {
                $cuenta++;
                break;
            }
        }

        if ($cuenta == 0) {
            $alquiler = DB::table('alquiler')->where('property_id', '=', $request->id)->get();

            foreach ($alquiler as $s => $ss) {
                if ($ss->end_date > $today) {
                    $cuenta++;
                    break;
                }
            }
        }

        if ($cuenta = 0){
            DB::table('users')->where('id', '=', $request->id)->delete();
        
            return redirect()->back()->with('success', 'La subasta se eliminado correctamente');
        }
        else {
            return redirect()->back()->with('error', 'La subasta no pudo eliminarse, dado que posee reservas y/o subastas por el momento');
        }        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function push_bid(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'actual_value' => 'required',
            'value' => 'required',
            'email' => 'required',
        ]);

        if ($request->get('value') < $request->get('actual_value')) {
            return redirect()->back()->with('error', 'El valor ingresado debe ser menor al monto actual de la subasta');
        }

        $bid = new Bid([
            'id' => $request->get('id'),
            'price' => $request->get('value'),
            'email' => $request->get('email'),
        ]);

        $bid->save();
        return redirect()->back()->with('success', 'Felicidades, ya estás participando de la subasta por un monto de: $'.$request->get('value'));
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
