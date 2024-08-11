<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Autorizacion_lote;
use App\Revision_lote;
use App\Aprobacion_lote;
use App\Solicitud_lote;
use App\Lote;
use Illuminate\Support\Facades\Auth;
class AutorizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   if(!$request->ajax()) return redirect('/');
        $nlote = $request->nombre;
        $solicitante = $request->solicitante;
        $aprobador = $request->aprobador;
        $autorizador=$request->autorizacion;
        if($nlote=='' && $solicitante=='' && $aprobador=='' && $autorizador==''){
            $aprobaciones = Aprobacion_lote::join('solicitud_lotes','aprobacion_lotes.idsolicitud','=','solicitud_lotes.id')
            ->join('users','aprobacion_lotes.idusuario','=','users.id')->select('solicitud_lotes.id as idsoli','solicitud_lotes.solicitante as solicitante',
            'solicitud_lotes.nombre as nlote','solicitud_lotes.stock_actual','solicitud_lotes.condicion as condicion_soli',
            'solicitud_lotes.ultima_solicitud','solicitud_lotes.cantidad','aprobacion_lotes.comentario',
            'solicitud_lotes.created_at','users.usuario','aprobacion_lotes.id','aprobacion_lotes.aprobador',
            'aprobacion_lotes.cantidad as cantidad_aprob','aprobacion_lotes.condicion','aprobacion_lotes.created_at as f_aprobacion')
            ->orderBy('id')->where('aprobacion_lotes.condicion','=','1')->get();
            $autorizaciones = Autorizacion_lote::join('aprobacion_lotes','autorizacion_lotes.idaprobacion','=','aprobacion_lotes.id')->
            join('solicitud_lotes','aprobacion_lotes.idsolicitud','=','solicitud_lotes.id')->
            join('users','autorizacion_lotes.idusuario','=','users.id')->
            select('solicitud_lotes.id as idsoli','solicitud_lotes.solicitante as solicitante',
            'solicitud_lotes.nombre as nlote','solicitud_lotes.stock_actual','solicitud_lotes.ultima_solicitud',
            'solicitud_lotes.cantidad','solicitud_lotes.created_at','aprobacion_lotes.comentario','aprobacion_lotes.id as idapro','aprobacion_lotes.aprobador',
            'aprobacion_lotes.created_at as f_aprobacion','aprobacion_lotes.cantidad as cantidad_aprob',
            'autorizacion_lotes.id','users.nombre as nombre_autorizador','users.apellido as apellido_autorizador',
            'users.usuario','autorizacion_lotes.condicion','autorizacion_lotes.created_at')->orderBy('id','desc')->paginate(10);
        }
        else{
            $aprobaciones = Aprobacion_lote::join('solicitud_lotes','aprobacion_lotes.idsolicitud','=','solicitud_lotes.id')
            ->join('users','aprobacion_lotes.idusuario','=','users.id')->select('solicitud_lotes.id as idsoli','solicitud_lotes.solicitante as solicitante',
            'solicitud_lotes.nombre as nlote','solicitud_lotes.stock_actual','solicitud_lotes.condicion as condicion_soli',
            'solicitud_lotes.ultima_solicitud','solicitud_lotes.cantidad','aprobacion_lotes.comentario',
            'solicitud_lotes.created_at','users.usuario','aprobacion_lotes.id','aprobacion_lotes.aprobador',
            'aprobacion_lotes.cantidad as cantidad_aprob','aprobacion_lotes.condicion','aprobacion_lotes.created_at as f_aprobacion')
            ->orderBy('id')->where('aprobacion_lotes.condicion','=','1')->get();
            $autorizaciones = Autorizacion_lote::join('aprobacion_lotes','autorizacion_lotes.idaprobacion','=','aprobacion_lotes.id')->
            join('solicitud_lotes','aprobacion_lotes.idsolicitud','=','solicitud_lotes.id')->
            join('users','autorizacion_lotes.idusuario','=','users.id')->
            select('solicitud_lotes.id as idsoli','solicitud_lotes.solicitante as solicitante',
            'solicitud_lotes.nombre as nlote','solicitud_lotes.stock_actual','solicitud_lotes.ultima_solicitud',
            'solicitud_lotes.cantidad','solicitud_lotes.created_at','aprobacion_lotes.comentario','aprobacion_lotes.id as idapro','aprobacion_lotes.aprobador',
            'aprobacion_lotes.created_at as f_aprobacion','aprobacion_lotes.cantidad as cantidad_aprob',
            'autorizacion_lotes.id','users.nombre as nombre_autorizador','users.apellido as apellido_autorizador',
            'users.usuario','autorizacion_lotes.condicion','autorizacion_lotes.autorizacion','autorizacion_lotes.created_at')->where('solicitud_lotes.nombre', 'like', '%'.$nlote.'%')
            ->where('solicitud_lotes.solicitante', 'like', '%'.$solicitante.'%')->where('aprobacion_lotes.aprobador', 'like', '%'.$aprobador.'%')
            ->where('autorizacion_lotes.autorizacion', 'like', '%'.$autorizador.'%')->orderBy('id','desc')->paginate(10);
        }


        return[
            'pagination' => [
                'total'          =>$autorizaciones->total(),
                'current_page'   =>$autorizaciones->currentPage(),
                'per_page'       =>$autorizaciones->perPage(),
                'last_page'      =>$autorizaciones->lastPage(),
                'from'           =>$autorizaciones->firstItem(),
                'to'             =>$autorizaciones->lastItem(),
            ],
            'autorizaciones' => $autorizaciones, 'aprobaciones' => $aprobaciones
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $autorizacion = new Autorizacion_lote();
        $autorizacion->idusuario = Auth::user()->id; 
        $autorizacion->autorizacion= Auth::user()->nombre.' '.Auth::user()->apellido;
        $autorizacion->idaprobacion = $request->aprobacion_id;
        $autorizacion->condicion='1';
        $autorizacion->save();
        
        $aprobacion = Aprobacion_lote::findOrFail($request->aprobacion_id);
        $aprobacion->condicion = '4';
        $aprobacion->save();

        $solicitud = Solicitud_lote::findOrFail($request->solicitud_id); 
        $solicitud->condicion ='6';        
        $solicitud->save();

        //Registra Lote
        $cont = Lote::All()->count();
        $num = Lote::whereYear('fecha_autorizacion',date('Y'))->count();
        $fin_codigo = Lote::orderBy('id','desc')->first();
        
        if(!$request->ajax())return redirect('/');
        $lote = new Lote();
        $lote->idautorizacion_lote = $autorizacion->id;
        $lote->numero = '00'.($num+1).'-'.date('y');
        $lote->nombre = $request->nlote;
        $lote->solicitante = $request->solicitante;
        $lote->aprobador = $request->aprobador;
        $lote->fecha_autorizacion = date('Y-m-d');
        if($cont > 0){
            $lote->start_code = $fin_codigo->end_code+1;
            $lote->end_code = $fin_codigo->end_code+$request->cantidad_aprob;
        }
        else{
            $lote->start_code = 14095;
            $lote->end_code = $request->cantidad_aprob+14094;
        }
        $lote->cantidad = $request->cantidad_aprob;
        $lote->stock = $request->cantidad_aprob;
        $lote->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $autorizacion = new Autorizacion_lote();
        $autorizacion->idusuario = Auth::user()->id; 
        $autorizacion->autorizacion= Auth::user()->nombre.''.Auth::user()->apellido;
        $autorizacion->idaprobacion = $request->aprobacion_id;
        $autorizacion->condicion='0';
        $autorizacion->save();

        $aprobacion = Aprobacion_lote::findOrFail($request->aprobacion_id);
        $aprobacion->condicion = '5';
        $aprobacion->save();

        $solicitud = Solicitud_lote::findOrFail($request->solicitud_id); 
        $solicitud->condicion ='7';        
        $solicitud->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $autorizacion = Autorizacion::findOrFail($request->id);
        $autorizacion->condicion ='0';
        $autorizacion->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $autorizacion = Autorizacion::findOrFail($request->id);
        $autorizacion->condicion ='1';
        $autorizacion->save();
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
