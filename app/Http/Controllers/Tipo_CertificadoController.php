<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipo_Certificado;
use App\TipoCCertifica;

class Tipo_CertificadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        if(!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio =$request->criterio;
        if($buscar==''){
            $tipos = Tipo_Certificado::orderBy('id','desc')->paginate(4);
        }
        else{
            $tipos= Tipo_Certificado::where('nombre','like','%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }
        return[
            'pagination' => [
                'total'          =>$tipos->total(),
                'current_page'   =>$tipos->currentPage(),
                'per_page'       =>$tipos->perPage(),
                'last_page'      =>$tipos->lastPage(),
                'from'           =>$tipos->firstItem(),
                'to'             =>$tipos->lastItem(),
            ],
            'tipos' => $tipos
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
        $tipo = new Tipo_Certificado();
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
        $tipo = Tipo_Certificado::findOrFail($request->id);
        $tipo->nombre=$request->nombre;
        $tipo->condicion='1';
        $tipo->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $tipo = Tipo_Certificado::findOrFail($request->id);
        $tipo->condicion = '0';
        $tipo->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $tipo = Tipo_Certificado::findOrFail($request->id);
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
    public function selectTipo_Certificado(Request $request){
        if(!$request->ajax()) return redirect('/');
        $tipos = Tipo_Certificado::where('condicion','=','1')->where('sede','=',1)
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['tipos' => $tipos];
    }
    public function selectTipoCCertifica(Request $request){
        if(!$request->ajax()) return redirect('/');
        $tipos = Tipo_Certificado::where('condicion','=','1')->where('sede','=',2)
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['tipos' => $tipos];
    }
}
