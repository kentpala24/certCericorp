<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio;

class ServicioController extends Controller
{
    public function index(Request $request)
    {  
        if(!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $empresa =$request->empresa;
        $criterio =$request->criterio;
        if($buscar=='' && $empresa==''){
            $servicios = Servicio::orderBy('id','desc')->paginate(4);
        }
        else{
            $servicios= Servicio::where('pdsi','like','%'.$buscar.'%')->where('empresa','like','%'.$empresa.'%')->orderBy('id','desc')->paginate(3);
        }
        return[
            'pagination' => [
                'total'          =>$servicios->total(),
                'current_page'   =>$servicios->currentPage(),
                'per_page'       =>$servicios->perPage(),
                'last_page'      =>$servicios->lastPage(),
                'from'           =>$servicios->firstItem(),
                'to'             =>$servicios->lastItem(),
            ],
            'servicios' => $servicios
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
        $tipo = new Servicio();
        $tipo->nombre=$request->nombre;
        $tipo->condicion='1';
        $tipo->save();
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
        if(!$request->ajax())return redirect('/');
        $tipo = Servicio::findOrFail($request->id);
        $tipo->nombre=$request->nombre;
        $tipo->condicion='1';
        $tipo->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $tipo = Servicio::findOrFail($request->id);
        $tipo->condicion = '0';
        $tipo->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $tipo = Servicio::findOrFail($request->id);
        $tipo->condicion = '1';
        $tipo->save();
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
    public function selectServicio(Request $request){
        if(!$request->ajax()) return redirect('/');
        $tipos = Servicio::where('condicion','=','1')->where('sede','=',1)
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['tipos' => $tipos];
    }
    public function selectTipoCCertifica(Request $request){
        if(!$request->ajax()) return redirect('/');
        $tipos = Servicio::where('condicion','=','1')->where('sede','=',2)
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['tipos' => $tipos];
    }
}
