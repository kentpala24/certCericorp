<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Lote;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $nlote = $request->buscar;
        $solicitante = $request->criterio;
        $aprobador = $request->aprobador;
        $autorizador=$request->autorizador;
        if($nlote=='' && $solicitante=='' && $aprobador=='' && $autorizador==''){
            $lotes = Lote::join('autorizacion_lotes','lotes.idautorizacion_lote','=','autorizacion_lotes.id')
            ->select('lotes.id','lotes.numero','lotes.nombre','lotes.solicitante','lotes.aprobador',
            'autorizacion_lotes.autorizacion','lotes.fecha_autorizacion','lotes.start_code','lotes.end_code','lotes.cantidad',
            'lotes.stock')->orderBy('id','desc')->paginate(10);
        }
        else{
            $lotes = Lote::join('autorizacion_lotes','lotes.idautorizacion_lote','=','autorizacion_lotes.id')
            ->select('lotes.id','lotes.numero','lotes.nombre','lotes.solicitante','lotes.aprobador',
            'autorizacion_lotes.autorizacion','lotes.fecha_autorizacion','lotes.start_code','lotes.end_code','lotes.cantidad',
            'lotes.stock')->orderBy('id','desc')->where('lotes.nombre', 'like', '%'.$nlote.'%')
            ->where('lotes.solicitante', 'like', '%'.$solicitante.'%')->where('lotes.aprobador', 'like', '%'.$aprobador.'%')
            ->where('autorizacion_lotes.autorizacion', 'like', '%'.$autorizador.'%')->paginate(10);
        }

        return [
            'pagination' => [
                'total'         => $lotes->total(),
                'current_page'  => $lotes->currentPage(),
                'per_page'      => $lotes->perPage(),
                'last_page'     => $lotes->lastPage(),
                'from'          => $lotes->firstItem(),
                'to'            => $lotes->lastItem(),
            ],
            'lotes'  =>  $lotes
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
        $cont = Lote::All()->count();
        $num = Lote::whereYear('fecha_autorizacion',date('Y'))->count();
        $fin_codigo = Lote::orderBy('id','desc')->first();
        
        if(!$request->ajax())return redirect('/');
        $lote = new Lote();
        $lote->idautorizacion_lote = Auth::user()->id;
        $lote->numero = '00'.($num+1).'-'.date('y');
        $lote->nombre = $request->nombre;
        $lote->solicitante = $request->solicitante;
        $lote->aprobador = $request->aprobador;
        $lote->fecha_autorizacion = date('Y-m-d');
        if($cont > 0){
            $lote->start_code = $fin_codigo->end_code+1;
            $lote->end_code = $fin_codigo->end_code+$request->cantidad;
        }
        else{
            $lote->start_code = 14095;
            $lote->end_code = $request->cantidad+14094;
        }
        $lote->cantidad = $request->cantidad;
        $lote->stock = $request->cantidad;
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

    public function selectLote(Request $request){
        if(!$request->ajax()) return redirect('/');
        $lotes = Lote::where('stock','>','0')
        ->select('id','numero','nombre')->where('sede','=','1')->orderBy('nombre','asc')->get();
        return ['lotes' => $lotes];
    }
    public function selectLoteUnico(Request $request){
        if(!$request->ajax()) return redirect('/');
        $lotes = Lote::where('stock','>','0')->where('id','=','34')
        ->select('id','numero','nombre')->orderBy('nombre','asc')->get();
        return ['lotes' => $lotes];
    }
}
