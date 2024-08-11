<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Tipo_Equipo;

class TipoEquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tipoCertificado = $request->tipoCertificado;
        $codTipoCert = $request->codTipoCert;
        $tipoEquipo = $request->tipoEquipo;
        
        if($tipoCertificado=='' && $codTipoCert=='' && $tipoEquipo==''){

            $tipoEquipos = Tipo_Equipo::orderBy('id','desc')->paginate(50);
        }
        else{
            $tipoEquipos= Tipo_Equipo::where('tipo_certificado','like','%'.$tipoCertificado.'%')->where('cod_tipo_cert','like','%'.$codTipoCert.'%')->where('tipo_equipo','like','%'.$tipoEquipo.'%')->orderBy('id','desc')->paginate(50);
        }
        return[
            'pagination' => [
                'total'          =>$tipoEquipos->total(),
                'current_page'   =>$tipoEquipos->currentPage(),
                'per_page'       =>$tipoEquipos->perPage(),
                'last_page'      =>$tipoEquipos->lastPage(),
                'from'           =>$tipoEquipos->firstItem(),
                'to'             =>$tipoEquipos->lastItem(),
            ],
            'tipoEquipos' => $tipoEquipos
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
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
          } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
          } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
          } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
          } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
          } else {
            // Método por defecto de obtener la IP del usuario
            // Si se utiliza un proxy, esto nos daría la IP del proxy
            // y no la IP real del usuario.
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if(!$request->ajax()) return redirect('/');
        $tipoEquipo = new Tipo_Equipo();
        $tipoEquipo->id_usuario = Auth::user()->id;
        $tipoEquipo->tipo_certificado=$request->tipo_certificado;
        $tipoEquipo->cod_tipo_cert=$request->cod_tipo_cert;
        $tipoEquipo->tipo_equipo=$request->tipo_equipo;
        $tipoEquipo->ip=$ip;
        $tipoEquipo->condicion='1';
        $tipoEquipo->save();
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
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
          } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
          } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
          } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
          } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
          } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if(!$request->ajax())return redirect('/');
        $tipoEquipo = Tipo_Equipo::findOrFail($request->id);
        $tipoEquipo->id_usuario = Auth::user()->id;
        $tipoEquipo->tipo_certificado=$request->tipo_certificado;
        $tipoEquipo->cod_tipo_cert=$request->cod_tipo_cert;
        $tipoEquipo->tipo_equipo=$request->tipo_equipo;
        $tipoEquipo->ip=$ip;
        $tipoEquipo->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $tipoEquipo = Tipo_Equipo::findOrFail($request->id);
        $tipoEquipo->condicion = '0';
        $tipoEquipo->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $tipoEquipo = Tipo_Equipo::findOrFail($request->id);
        $tipoEquipo->condicion = '1';
        $tipoEquipo->save();
    }

    public function selectTipoEquipo(Request $request){
      if(!$request->ajax()) return redirect('/');
      $tipoEquipo = Tipo_Equipo::where('condicion','=','1')
      ->select('id','tipo_equipo')->orderBy('tipo_equipo','asc')->get();
      return ['tipoEquipos' => $tipoEquipo];
  }
}
