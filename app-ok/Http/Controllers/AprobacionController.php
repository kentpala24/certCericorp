<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Aprobacion_lote;
use App\Solicitud_lote;

class AprobacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   if(!$request->ajax()) return redirect('/');
        $nombreS =$request->nombreS;
        $solicitante =$request->solicitante;
        $aprobador =$request->aprobador;
        if($nombreS=='' && $solicitante=='' && $aprobador==''){
            $soli_lot = Solicitud_lote::join('users','solicitud_lotes.idusuario','=','users.id')
            ->select('users.nombre as nusuario','users.apellido','users.usuario','solicitud_lotes.id',
            'solicitud_lotes.nombre','solicitud_lotes.stock_actual','solicitud_lotes.ultima_solicitud',
            'solicitud_lotes.cantidad','solicitud_lotes.comentario','solicitud_lotes.condicion','solicitud_lotes.created_at')
            ->OrderBy('id','desc')->where('solicitud_lotes.condicion','=','1')->get();
            $aprobaciones = Aprobacion_lote::join('solicitud_lotes','aprobacion_lotes.idsolicitud','=','solicitud_lotes.id')
            ->join('users','aprobacion_lotes.idusuario','=','users.id')->select('solicitud_lotes.id as idsoli','solicitud_lotes.solicitante as solicitante',
            'solicitud_lotes.nombre as nlote','solicitud_lotes.stock_actual','solicitud_lotes.condicion as condicion_soli',
            'solicitud_lotes.ultima_solicitud','solicitud_lotes.cantidad','solicitud_lotes.comentario','aprobacion_lotes.aprobador',
            'solicitud_lotes.created_at','users.nombre as nombre_aprobador','users.apellido as apellido_aprobador','users.usuario','aprobacion_lotes.id',
            'aprobacion_lotes.cantidad as cantidad_aprob','aprobacion_lotes.condicion','aprobacion_lotes.created_at as f_aprobacion')
            ->orderBy('id','desc')->paginate(10);
            
        }
        else{
            $soli_lot = Solicitud_lote::join('users','solicitud_lotes.idusuario','=','users.id')
            ->select('users.nombre as nusuario','users.apellido','users.usuario','solicitud_lotes.id',
            'solicitud_lotes.nombre','solicitud_lotes.stock_actual','solicitud_lotes.ultima_solicitud',
            'solicitud_lotes.cantidad','solicitud_lotes.comentario','solicitud_lotes.condicion','solicitud_lotes.created_at')
            ->OrderBy('id','desc')->where('solicitud_lotes.condicion','=','1')->get();
            $aprobaciones= Aprobacion_lote::join('solicitud_lotes','aprobacion_lotes.idsolicitud','=','solicitud_lotes.id')
            ->join('users','aprobacion_lotes.idusuario','=','users.id')->select('solicitud_lotes.id as idsoli','solicitud_lotes.solicitante as solicitante',
            'solicitud_lotes.nombre as nlote','solicitud_lotes.stock_actual','solicitud_lotes.condicion as condicion_soli',
            'solicitud_lotes.ultima_solicitud','solicitud_lotes.cantidad','solicitud_lotes.comentario','aprobacion_lotes.aprobador',
            'solicitud_lotes.created_at','users.nombre as nombre_aprobador','users.apellido as apellido_aprobador','users.usuario','aprobacion_lotes.id',
            'aprobacion_lotes.cantidad as cantidad_aprob','aprobacion_lotes.condicion','aprobacion_lotes.created_at as f_aprobacion')
            ->where('solicitud_lotes.solicitante', 'like', '%'.$solicitante.'%')->where('solicitud_lotes.nombre', 'like', '%'.$nombreS.'%')->where('aprobacion_lotes.aprobador', 'like', '%'.$aprobador.'%')->orderBy('id','desc')->paginate(10);
        
        }


        return[
            'pagination' => [
                'total'          =>$aprobaciones->total(),
                'current_page'   =>$aprobaciones->currentPage(),
                'per_page'       =>$aprobaciones->perPage(),
                'last_page'      =>$aprobaciones->lastPage(),
                'from'           =>$aprobaciones->firstItem(),
                'to'             =>$aprobaciones->lastItem(),
            ],
            'aprobaciones' => $aprobaciones,'soli_lot' => $soli_lot
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
        $aprobacion = new Aprobacion_lote();
        $aprobacion->idusuario = Auth::user()->id;
        $aprobacion->idsolicitud =$request->id;
        $aprobacion->cantidad=$request->cantidad;
        $aprobacion->comentario=$request->comentario;
        $aprobacion->aprobador= Auth::user()->nombre.' '.Auth::user()->apellido;
        $aprobacion->condicion='1';
        $aprobacion->save();

        $solicitud = Solicitud_lote::findOrFail($request->id); 
        $solicitud->condicion ='2';        
        $solicitud->save();
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
        $aprobacion = new Aprobacion_lote();
        $aprobacion->idusuario = Auth::user()->id;
        $aprobacion->idsolicitud =$request->id;
        $aprobacion->cantidad=$request->cantidad;
        $aprobacion->comentario=$request->comentario;
        $aprobacion->aprobador= Auth::user()->nombre.''.Auth::user()->apellido;
        $aprobacion->condicion='0';
        $aprobacion->save();

        $solicitud = Solicitud_lote::findOrFail($request->id); 
        $solicitud->condicion ='3';        
        $solicitud->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $aprobacion = Aprobacion_lote::findOrFail($request->id);
        $aprobacion->condicion ='0';
        $aprobacion->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $aprobacion = Aprobacion_lote::findOrFail($request->id);
        $aprobacion->condicion ='1';
        $aprobacion->save();
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
