<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Solicitud_lote;
use App\Lote;
use App\Mail\MessageReceived;
use Illuminate\Support\Facades\Mail;

class SolicitudlotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        if(!$request->ajax()) return redirect('/');
        $solicitante =$request->solicitante;
        $criterio =$request->criterio;
        $stock_actual = Lote::All()->where('stock','>','0');
        $creacion=Solicitud_lote::OrderBy('id','desc')->select('created_at')->first();
        $cont=Solicitud_lote::OrderBy('id','desc')->select('created_at')->count();
        if($cont>0){
            $ultima_solicitud=$creacion->created_at->format('Y-m-d');
        }
        else{
            $ultima_solicitud='';
        }
        if($solicitante=='' && $criterio==''){
            $soli_lot = Solicitud_lote::join('users','solicitud_lotes.idusuario','=','users.id')
            ->select('users.nombre as nusuario','users.apellido','users.usuario','solicitud_lotes.id',
            'solicitud_lotes.nombre','solicitud_lotes.stock_actual','solicitud_lotes.ultima_solicitud',
            'solicitud_lotes.cantidad','solicitud_lotes.comentario','solicitud_lotes.condicion','solicitud_lotes.created_at')
            ->OrderBy('id','desc')->paginate(10);
        }
        else{
            $soli_lot= Solicitud_lote::join('users','solicitud_lotes.idusuario','=','users.id')
            ->select('users.nombre as nusuario','users.apellido','users.usuario','solicitud_lotes.id',
            'solicitud_lotes.nombre','solicitud_lotes.stock_actual','solicitud_lotes.ultima_solicitud','solicitud_lotes.solicitante',
            'solicitud_lotes.cantidad','solicitud_lotes.comentario','solicitud_lotes.condicion','solicitud_lotes.created_at')
            ->where('solicitud_lotes.solicitante', 'like', '%'.$solicitante.'%')->where('solicitud_lotes.nombre', 'like', '%'.$criterio.'%')->orderBy('id','desc')->paginate(10);
        }


        return[
            'pagination' => [
                'total'          =>$soli_lot->total(),
                'current_page'   =>$soli_lot->currentPage(),
                'per_page'       =>$soli_lot->perPage(),
                'last_page'      =>$soli_lot->lastPage(),
                'from'           =>$soli_lot->firstItem(),
                'to'             =>$soli_lot->lastItem(),
            ],
            'soli_lot' => $soli_lot,'ultima' => $ultima_solicitud, 'stock_real' => $stock_actual,
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
    {   if(!$request->ajax()) return redirect('/');
        $stock_actual = Lote::All()->where('stock','>','0');
        $hola = "";
        foreach($stock_actual as $stock_actuals){
            $hola = "$hola  $stock_actuals->stock Certificates | $stock_actuals->numero $stock_actuals->nombre<br/>";
        }
        $creacion=Solicitud_lote::OrderBy('id','desc')->select('created_at')->first();
        $cont=Solicitud_lote::OrderBy('id','desc')->select('created_at')->count();
        if($cont>0){
            $ultima_solicitud=$creacion->created_at->format('Y-m-d');

        }
        else{
            $ultima_solicitud=date('Y-m-d');
        }
        
        if(!$request->ajax()) return redirect('/');
        $sol = new Solicitud_lote();
        $sol->idusuario = Auth::user()->id;
        $sol->solicitante = Auth::user()->nombre.' '.Auth::user()->apellido;
        $sol->nombre=$request->nombre;
        $sol->stock_actual=$hola;
        $sol->ultima_solicitud=$ultima_solicitud;
        $sol->cantidad=$request->cantidad;
        $sol->comentario=$request->comentario;
        $sol->condicion='1';
        $sol->save();
        
        //Enviar Correo

        Mail::to('kpalacios.cicbla@gmail.com')->send(new MessageReceived);
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

    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $sol = Solicitud_lote::findOrFail($request->id);
        $sol->condicion = '0';
        $sol->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $sol = Solicitud_lote::findOrFail($request->id);
        $sol->condicion = '1';
        $sol->save();
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
