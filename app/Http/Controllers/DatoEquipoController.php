<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Dato_Equipo;
use Illuminate\Support\Facades\DB;

class DatoEquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $idCliente = $request->id_cliente;
        $marca = $request->marca;
        $modelo = $request->modelo;
        
        if($idCliente=='' && $marca=='' && $modelo==''){

            $datoEquipo = Dato_Equipo::select('clientes.id as id_cliente','clientes.cliente','dato_equipo.id_tipo_equipo','dato_equipo.id','dato_equipo.marca','dato_equipo.modelo','dato_equipo.serie','dato_equipo.cod_interno'
            ,'dato_equipo.capacidad','dato_equipo.fabricante','dato_equipo.anio','dato_equipo.condicion')->
            join('clientes','clientes.id','=','dato_equipo.id_cliente')->orderBy('dato_equipo.id','desc')->paginate(50);
        }
        else{
            $datoEquipo= Dato_Equipo::select('clientes.id as id_cliente','clientes.cliente','dato_equipo.id_tipo_equipo','dato_equipo.id','dato_equipo.id','dato_equipo.marca','dato_equipo.modelo','dato_equipo.serie','dato_equipo.cod_interno'
            ,'dato_equipo.capacidad','dato_equipo.fabricante','dato_equipo.anio','dato_equipo.condicion')->
            join('clientes','clientes.id','=','dato_equipo.id_cliente')->where('dato_equipo.id_cliente','like','%'.$idCliente)->where('dato_equipo.marca','like','%'.$marca.'%')->where('dato_equipo.modelo','like','%'.$modelo.'%')->orderBy('id','desc')->paginate(50);
        }
        return[
            'pagination' => [
                'total'          =>$datoEquipo->total(),
                'current_page'   =>$datoEquipo->currentPage(),
                'per_page'       =>$datoEquipo->perPage(),
                'last_page'      =>$datoEquipo->lastPage(),
                'from'           =>$datoEquipo->firstItem(),
                'to'             =>$datoEquipo->lastItem(),
            ],
            'datoEquipos' => $datoEquipo
        ];
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
        $datoEquipo = new Dato_Equipo();
        $datoEquipo->id_usuario = Auth::user()->id;
        $datoEquipo->id_cliente=$request->id_cliente;
        $datoEquipo->marca=$request->marca;
        $datoEquipo->modelo=$request->modelo;
        $datoEquipo->serie=$request->serie;
        $datoEquipo->cod_interno=$request->cod_interno;
        $datoEquipo->capacidad=$request->capacidad;
        $datoEquipo->fabricante=$request->fabricante;
        $datoEquipo->anio=$request->anio;
        $datoEquipo->id_tipo_equipo=$request->idTipoEquipo;
        $datoEquipo->ip=$ip;
        $datoEquipo->condicion='1';
        $datoEquipo->save();
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
        $datoEquipo = Dato_Equipo::findOrFail($request->id);
        $datoEquipo->id_usuario = Auth::user()->id;
        $datoEquipo->id_cliente=$request->id_cliente;
        $datoEquipo->marca=$request->marca;
        $datoEquipo->modelo=$request->modelo;
        $datoEquipo->serie=$request->serie;
        $datoEquipo->cod_interno=$request->cod_interno;
        $datoEquipo->capacidad=$request->capacidad;
        $datoEquipo->fabricante=$request->fabricante;
        $datoEquipo->anio=$request->anio;
        $datoEquipo->id_tipo_equipo=$request->idTipoEquipo;
        $datoEquipo->ip=$ip;
        $datoEquipo->condicion='1';
        $datoEquipo->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $datoEquipo = Dato_Equipo::findOrFail($request->id);
        $datoEquipo->condicion = '0';
        $datoEquipo->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $datoEquipo = Dato_Equipo::findOrFail($request->id);
        $datoEquipo->condicion = '1';
        $datoEquipo->save();
    }
    public function selectEquipos(Request $request){
        if(!$request->ajax()) return redirect('/');
        $equipos = Dato_Equipo::where('condicion','=','1')
        ->select('id',DB::raw("CONCAT(marca,' ',modelo,' / ',serie) as equipo"))->orderBy('marca','asc')->get();
        return ['equipos' => $equipos];
    }
}
