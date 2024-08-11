<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certificado;
use App\Persona;
use App\Equipo;
use App\Servicio;
use Carbon\Carbon;
use DB;

class ValidacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {

        return view('search.search');
    }
    public function searcheq()
    {

        return view('search.searcheq');
    }
    public function validacion(Request $request)
    {   
            $numero=$request->certificado;
        $dni = $request->dni;
        $profesionales = Persona::select('personas.id as idpersona','personas.nombre','personas.apellido','personas.dni','personas.empresa')->where('personas.dni','=',$dni)->get();
        
        $certificados = Certificado::join('users','certificados.idusuario','=','users.id')->
      join('personas','certificados.idpersona','=','personas.id')->
      join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
      join('lotes','certificados.idlote','=','lotes.id')->
      join('firmas','certificados.idfirma','=','firmas.id')->
      join('designacions','certificados.iddesignacion','=','designacions.id')->
      select('users.nombre as usuario_nombre','users.apellido as usuario_apellido','personas.id as idpersona','personas.nombre','personas.apellido','personas.dni',
      'lotes.id as idlote','lotes.nombre as nombre_lote','lotes.numero','certificados.id','certificados.pdsi','certificados.empresa','certificados.certificado','certificados.cod_certificado',
      'certificados.designacion','certificados.equipo','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','certificados.level','certificados.horas',
      'certificados.normativa','certificados.qr','certificados.fecha_expiracion','certificados.ip','certificados.condicion',
      'certificados.fecha_emision','certificados.fecha_emision2','certificados.fecha_emision3','certificados.fecha_emision4'
      ,'certificados.fecha_emision5','certificados.fecha_emision6','certificados.fecha_emision7','certificados.persona','designacions.normativa_espanol',
      'certificados.cond_equipo','certificados.dias','certificados.fecha_revalidacion','certificados.fecha_expiracion','designacions.identifica_ingles','designacions.identifica',
      'certificados.description','certificados.cabecera','certificados.fecha',
      'certificados.lugar','certificados.capacidad','certificados.resultado','certificados.puntaje','certificados.separacion','certificados.informes','certificados.modelo','certificados.fecha_ulti_certi',
      'certificados.idfirma','firmas.nombre as firma_nombre','firmas.imagen')->where('personas.dni','=',$dni)->where('certificados.cod_certificado','like','%'.$numero.'%')->where('certificados.condicion','=','2')->OrderBy('certificado','desc')->get();
        
        /*$certificados = Certificado::join('users','certificados.idusuario','=','users.id')->
        join('personas','certificados.idpersona','=','personas.id')->
        join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
        join('lotes','certificados.idlote','=','lotes.id')->
        join('firmas','certificados.idfirma','=','firmas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('users.nombre as usuario_nombre','users.apellido as usuario_apellido','personas.id as idpersona','personas.nombre','personas.apellido','personas.dni',
        'lotes.id as idlote','lotes.nombre as nombre_lote','lotes.numero','certificados.id','certificados.pdsi','certificados.empresa','certificados.certificado',
        'certificados.designacion','certificados.equipo','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','certificados.level','certificados.horas',
        'certificados.normativa','certificados.qr','certificados.ip','certificados.condicion',
        'certificados.fecha_emision','certificados.fecha_emision2','certificados.fecha_emision3','certificados.fecha_emision4'
        ,'certificados.fecha_emision5','certificados.fecha_emision6','certificados.fecha_emision7','certificados.persona','certificados.sede',
        'certificados.cond_equipo','certificados.dias','certificados.fecha_revalidacion','certificados.fecha_expiracion',
        'certificados.description','certificados.cabecera','certificados.fecha','designacions.identifica_ingles',
        'firmas.id as idfirma','firmas.nombre as firma_nombre')->OrderBy('id','desc')->where('personas.dni','=',$dni)->where('certificados.cod_certificado','like','%'.$numero.'%')->where('certificados.condicion','=','2')->get();*/
        
                $cont = Certificado::join('users','certificados.idusuario','=','users.id')->
      join('personas','certificados.idpersona','=','personas.id')->
      join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
      join('lotes','certificados.idlote','=','lotes.id')->
      join('firmas','certificados.idfirma','=','firmas.id')->
      join('designacions','certificados.iddesignacion','=','designacions.id')->
      select('users.nombre as usuario_nombre','users.apellido as usuario_apellido','personas.id as idpersona','personas.nombre','personas.apellido','personas.dni',
      'lotes.id as idlote','lotes.nombre as nombre_lote','lotes.numero','certificados.id','certificados.pdsi','certificados.empresa','certificados.certificado','certificados.cod_certificado',
      'certificados.designacion','certificados.equipo','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','certificados.level','certificados.horas',
      'certificados.normativa','certificados.qr','certificados.ip','certificados.condicion',
      'certificados.fecha_emision','certificados.fecha_emision2','certificados.fecha_emision3','certificados.fecha_emision4'
      ,'certificados.fecha_emision5','certificados.fecha_emision6','certificados.fecha_emision7','certificados.persona','designacions.normativa_espanol',
      'certificados.cond_equipo','certificados.dias','certificados.fecha_revalidacion','certificados.fecha_expiracion','designacions.identifica_ingles','designacions.identifica',
      'certificados.description','certificados.cabecera','certificados.fecha',
      'certificados.lugar','certificados.capacidad','certificados.resultado','certificados.puntaje','certificados.separacion','certificados.informes','certificados.modelo','certificados.fecha_ulti_certi',
      'certificados.idfirma','firmas.nombre as firma_nombre','firmas.imagen')->where('personas.dni','=',$dni)->where('certificados.cod_certificado','like','%'.$numero.'%')->where('certificados.condicion','=','2')->OrderBy('certificado','desc')->count();
      
        /*$cont = Certificado::join('users','certificados.idusuario','=','users.id')->
        join('personas','certificados.idpersona','=','personas.id')->
        join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
        join('lotes','certificados.idlote','=','lotes.id')->
        join('firmas','certificados.idfirma','=','firmas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('users.nombre as usuario_nombre','users.apellido as usuario_apellido','personas.id as idpersona','personas.nombre','personas.apellido','personas.dni',
        'lotes.id as idlote','lotes.nombre as nombre_lote','lotes.numero','certificados.id','certificados.pdsi','certificados.empresa','certificados.certificado',
        'certificados.designacion','certificados.equipo','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','certificados.level','certificados.horas',
        'certificados.normativa','certificados.qr','certificados.ip','certificados.condicion',
        'certificados.fecha_emision','certificados.fecha_emision2','certificados.fecha_emision3','certificados.fecha_emision4'
        ,'certificados.fecha_emision5','certificados.fecha_emision6','certificados.fecha_emision7','certificados.persona',
        'certificados.cond_equipo','certificados.dias','certificados.fecha_revalidacion','certificados.fecha_expiracion',
        'certificados.description','certificados.cabecera','certificados.fecha','designacions.identifica_ingles',
        'firmas.id as idfirma','firmas.nombre as firma_nombre')->OrderBy('id','desc')->where('personas.dni','=',$dni)->where('certificados.cod_certificado','like','%'.$numero.'%')->where('certificados.condicion','=','2')->count();*/
        if($cont==0){
            return view('search.search',['cont'=>$cont]);
        }
        else{
            return view('search.validacion',['certificados'=>$certificados,'cont'=>$cont,'profesionales'=>$profesionales]);
        }
        
    }
    public function validacioneq(Request $request)
    {   //if(!$request->ajax()) return redirect('/');
        $serie = $request->serie;
        $certificado = $request->certificado;
        
        $equipos = Equipo::join('clientes as c','c.id','=','certificado_equipo.id_cliente')->
        join('dato_equipo as d','d.id','=','certificado_equipo.id_equipo')->
        join('tipo_equipo as t','t.id','=','d.id_tipo_equipo')->
        select('c.id as id_cliente','c.cliente','certificado_equipo.id','certificado_equipo.certificado','certificado_equipo.fecha_inspeccion','certificado_equipo.fecha_emision'
        ,'certificado_equipo.lugar','certificado_equipo.fecha_inspeccion2','certificado_equipo.fecha_expiracion',
        't.id as id_tipo_equipo','t.tipo_equipo','certificado_equipo.propietario','d.id as id_dato_equipo','d.marca','d.modelo','d.serie','d.cod_interno','d.fabricante',
        'd.anio','certificado_equipo.campo1','certificado_equipo.resultado1','certificado_equipo.campo2','certificado_equipo.resultado2',
        'certificado_equipo.normativa','certificado_equipo.capa_maxima','certificado_equipo.peso_certificacion','certificado_equipo.tasa_prueba',
        'certificado_equipo.longitud_pluma','certificado_equipo.angulo_pluma','certificado_equipo.radio_opera','certificado_equipo.informe',
        'certificado_equipo.vigencia','certificado_equipo.estado','certificado_equipo.id_firma2','certificado_equipo.separador','certificado_equipo.id_firma')
        ->where('d.serie','=',$serie)->where('certificado_equipo.certificado','=',$certificado)->where('estado','=','2')->get();
        //dd($equipos);
        $cont = Equipo::join('clientes as c','c.id','=','certificado_equipo.id_cliente')->
        join('dato_equipo as d','d.id','=','certificado_equipo.id_equipo')->
        join('tipo_equipo as t','t.id','=','d.id_tipo_equipo')->
        select('c.id as id_cliente','c.cliente','certificado_equipo.id','certificado_equipo.certificado','certificado_equipo.fecha_inspeccion','certificado_equipo.fecha_emision'
        ,'certificado_equipo.lugar','certificado_equipo.fecha_inspeccion2','certificado_equipo.fecha_expiracion',
        't.id as id_tipo_equipo','t.tipo_equipo','certificado_equipo.propietario','d.id as id_dato_equipo','d.marca','d.modelo','d.serie','d.cod_interno','d.fabricante',
        'd.anio','certificado_equipo.campo1','certificado_equipo.resultado1','certificado_equipo.campo2','certificado_equipo.resultado2',
        'certificado_equipo.normativa','certificado_equipo.capa_maxima','certificado_equipo.peso_certificacion','certificado_equipo.tasa_prueba',
        'certificado_equipo.longitud_pluma','certificado_equipo.angulo_pluma','certificado_equipo.radio_opera','certificado_equipo.informe',
        'certificado_equipo.vigencia','certificado_equipo.estado','certificado_equipo.id_firma2','certificado_equipo.separador','certificado_equipo.id_firma')
        ->where('d.serie','=',$serie)->where('certificado_equipo.certificado','=',$certificado)->where('estado','=','2')->count();
        if($cont==0){
            return view('search.searcheq',['cont'=>$cont]);
        }
        else{
            return view('search.validacioneq',['equipos'=>$equipos,'cont'=>$cont]);
        }
        
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
        //
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
}
