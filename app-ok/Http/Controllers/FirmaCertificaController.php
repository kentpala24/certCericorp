<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Firma;

class FirmaCertificaController extends Controller
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
            $firmas = Firma::orderBy('id','desc')->where('sede','=',2)->paginate(3);
        }
        else{
            $firmas= Firma::where($criterio,'like','%'.$buscar.'%')->where('sede','=',2)->orderBy('id','desc')->paginate(3);
        }
        return[
            'pagination' => [
                'total'          =>$firmas->total(),
                'current_page'   =>$firmas->currentPage(),
                'per_page'       =>$firmas->perPage(),
                'last_page'      =>$firmas->lastPage(),
                'from'           =>$firmas->firstItem(),
                'to'             =>$firmas->lastItem(),
            ],
            'firmas' => $firmas
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
    {  if(!$request->ajax()) return redirect('/');
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
        if($request->hasFile('image')){
            $name = time().$request->file('image')->getClientOriginalName();
            $pathToFile = $request->file('image')->storeAs('images',$name,'public');
        }
        else{
            $pathToFile='';
        }
        if(!$request->ajax()) return redirect('/');
        $firma = new Firma();
        $firma->idusuario = Auth::user()->id;
        $firma->nombre=$request->nombre;
        if($pathToFile==''){

        }
        else{
            $firma->imagen=$pathToFile;
        }
        $firma->ip=$ip;
        $firma->nombreF=$request->nombreF;
        $firma->entidad=$request->entidad;
        $firma->tipo=$request->tipo;
        $firma->certificado=$request->certificado;
        $firma->otros=$request->otros;
        $firma->condicion='1';
        $firma->sede=2;
        $firma->save();
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
    {   if(!$request->ajax()) return redirect('/');
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
        if($request->hasFile('image')){
            $name = time().$request->file('image')->getClientOriginalName();
            $pathToFile = $request->file('image')->storeAs('images',$name,'public');
        }
        else{
            $pathToFile='';
        }
        if(!$request->ajax())return redirect('/');
        $firma = Firma::findOrFail($request->id);
        $firma->nombre=$request->nombre;
        $firma->nombreF=$request->nombreF;
        $firma->entidad=$request->entidad;
        $firma->tipo=$request->tipo;
        $firma->certificado=$request->certificado;
        $firma->otros=$request->otros;
        if($pathToFile==''){

        }
        else{
            $firma->imagen=$pathToFile;
        }
        $firma->ip=$ip;
        $firma->condicion='1';
        $firma->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $firma = Firma::findOrFail($request->id);
        $firma->condicion = '0';
        $firma->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $firma = Firma::findOrFail($request->id);
        $firma->condicion = '1';
        $firma->save();
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
    public function selectFirma(Request $request){
        if(!$request->ajax()) return redirect('/');
        $firmas = Firma::where('condicion','=','1')
        ->select('id','nombre','nombreF','entidad','tipo','certificado','otros')->orderBy('nombre','asc')->get();
        return ['firmas' => $firmas];
    }
}
