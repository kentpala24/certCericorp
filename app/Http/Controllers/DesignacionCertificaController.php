<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Designacion;

class DesignacionCertificaController extends Controller
{
    public function designacion(Request $request)
    {  
        //if(!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio =$request->criterio;
        if($buscar==''){
            $designaciones = Designacion::join('tipo_certificados','designacions.idtipo_certificado','=','tipo_certificados.id')
            ->select('designacions.id','designacions.designacion_ingles','designacions.designacion_espanol','designacions.identifica','designacions.identifica_ingles','designacions.color',
            'designacions.normativa_ingles','designacions.normativa_espanol','designacions.estado','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre')->where('designacions.sede','=',2)
            ->orderBy('id','desc')->paginate(3);
        }
        else{
            $designaciones= Designacion::join('tipo_certificados','designacions.idtipo_certificado','=','tipo_certificados.id')
            ->select('designacions.id','designacions.designacion_ingles','designacions.designacion_espanol','designacions.identifica','designacions.color',
            'designacions.normativa_ingles','designacions.normativa_espanol','designacions.estado','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre')->where('designacions.sede','=',2)
            ->where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(10);
        }
        return[
            'pagination' => [
                'total'          =>$designaciones->total(),
                'current_page'   =>$designaciones->currentPage(),
                'per_page'       =>$designaciones->perPage(),
                'last_page'      =>$designaciones->lastPage(),
                'from'           =>$designaciones->firstItem(),
                'to'             =>$designaciones->lastItem(),
            ],
            'designaciones' => $designaciones
        ];
    }

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
        
        $designaciones = new Designacion();
        $designaciones->idusuario = Auth::user()->id;
        $designaciones->idtipo_certificado=$request->idtipo_certificado;
        $designaciones->designacion_ingles=$request->designacion_ingles;
        $designaciones->designacion_espanol=$request->designacion_espanol;
        $designaciones->identifica=$request->identifica;
        $designaciones->identifica_ingles=$request->identifica_ingles;
        $designaciones->color=$request->color;
        $designaciones->normativa_ingles=$request->normativa_ingles;
        $designaciones->normativa_espanol=$request->normativa_espanol;
        $designaciones->ip=$ip;
        $designaciones->estado='1';
        $designaciones->sede='2';
        $designaciones->save();
    }

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
            // Método por defecto de obtener la IP del usuario
            // Si se utiliza un proxy, esto nos daría la IP del proxy
            // y no la IP real del usuario.
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        $designaciones = Designacion::findOrFail($request->id);
        $designaciones->idusuario = Auth::user()->id;
        $designaciones->idtipo_certificado=$request->idtipo_certificado;
        $designaciones->designacion_ingles=$request->designacion_ingles;
        $designaciones->designacion_espanol=$request->designacion_espanol;
        $designaciones->identifica=$request->identifica;
        $designaciones->identifica_ingles=$request->identifica_ingles;
        $designaciones->color=$request->color;
        $designaciones->normativa_ingles=$request->normativa_ingles;
        $designaciones->normativa_espanol=$request->normativa_espanol;
        $designaciones->ip=$ip;
        $designaciones->estado='1';
        $designaciones->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $designaciones = Designacion::findOrFail($request->id);
        $designaciones->estado = '0';
        $designaciones->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $designaciones = Designacion::findOrFail($request->id);
        $designaciones->estado = '1';
        $designaciones->save();
    }

    public function selectDesignacion(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $designaciones = Designacion::where('estado','=','1')
        ->select('id','designacion_ingles','designacion_espanol')->where('idtipo_certificado','=',$request->idtipo_certificado)
        ->orderBy('designacion_ingles','asc')->get();
        return ['designaciones' => $designaciones];
    }
    public function buscarDesignacion(Request $request){
      //if(!$request->ajax()) return redirect('/');
      $designaciones = Designacion::where('estado','=','1')->where('id','=',$request->filtro)
      ->select('id','designacion_ingles','designacion_espanol','normativa_ingles','normativa_espanol')->get();
      return ['designaciones' => $designaciones];
  }
}
