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
    public function apiExpe(Request $request) {
        $dni = $request->dni;
        $ind = $request->indi;
        $course = $request->idcurso;
        $sql="select p.id, p.dni,CONCAT('P-',c.certificado) certificado,c.persona, c.designacion, tc.nombre,c.equipo,c.level from certificados c";
        $sql="$sql inner join personas p on p.id=c.idpersona INNER JOIN designacions d on d.id=c.iddesignacion INNER JOIN tipo_certificados tc";
        $sql="$sql on tc.id=c.idtipo_certificado WHERE p.dni in ($dni) AND (d.id_curso=$course or d.id_curso_mmg=$course) AND c.certificado<>0 AND c.condicion=2 group by p.id, p.dni,c.certificado";
        //dd($sql);
        $Participantes = DB::select($sql);
        
        echo json_encode($Participantes,true);

    }
    public function validacion(Request $request)
    {   //if(!$request->ajax()) return redirect('/');
        $cert = preg_replace("/[^0-9]/", "", $request->certificado);
        if($cert==0){
            $numero='';
        }
        else{
            $numero=$cert;
        }
        $dni = $request->dni;
        $profesionales = Persona::select('personas.id as idpersona','personas.nombre','personas.apellido','personas.dni','personas.empresa')->where('personas.dni','=',$dni)->get();
        $certificados = Certificado::join('users','certificados.idusuario','=','users.id')->
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
        'firmas.id as idfirma','firmas.nombre as firma_nombre')->OrderBy('id','desc')->where('personas.dni','=',$dni)->where('certificados.certificado','like','%'.$numero.'%')->where('certificados.condicion','=','2')->get();
        $cont = Certificado::join('users','certificados.idusuario','=','users.id')->
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
        'firmas.id as idfirma','firmas.nombre as firma_nombre')->OrderBy('id','desc')->where('personas.dni','=',$dni)->where('certificados.certificado','like','%'.$numero.'%')->where('certificados.condicion','=','2')->count();
        if($cont==0){
            return view('search.search',['cont'=>$cont]);
        }
        else{
            return view('search.validacion',['certificados'=>$certificados,'cont'=>$cont,'profesionales'=>$profesionales]);
        }
        
    }
    public function apiCert(Request $request) {
        $idproyecto = $request->proyecto;
        $idCliente = $request->cliente;
        $certificados = Certificado::join('personas','certificados.idpersona','=','personas.id')->
        join('carnes','certificados.id','=','carnes.idcertificado')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('certificados.id','certificados.idusuario','certificados.pdsi','certificados.persona','certificados.empresa','certificados.certificado','certificados.indi_mayo_21to',
        'certificados.iddesignacion','certificados.designacion','certificados.equipo','certificados.level','certificados.horas','certificados.fecha_emision','certificados.fecha_emision7',
        'certificados.fecha_expiracion','certificados.dias','certificados.normativa','certificados.proyecto_id',
        'personas.dni','designacions.id_curso','designacions.id_curso_mmg','carnes.fecha_reevaluacion')->
        //where(function($query) use ($idproyecto,$idCliente){$query->where('certificados.proyecto_id','=',$idproyecto)->orWhere('performance_type_id','=','3');})->
        where('certificados.proyecto_id','=',$idproyecto)->where('certificados.condicion','<>',0)->
        orwhere(function($query) use ($idCliente){$query->where('certificados.cli_id','=',$idCliente)->Where('carnes.reevaluacion','=','1')->Where('carnes.fecha_reevaluacion','<>','0000-00-00')->whereNotNull('carnes.fecha_reevaluacion')->where('certificados.condicion','<>',0);})->
        get();
        echo json_encode($certificados,true);
    }
    public function apiServ(Request $request) {
        $idproyecto = $request->proyecto;
        $idcliente = $request->idcliente;
        $idGep = $request->idGep;
        $pdsi = $request->pdsi;
        $empresa = $request->cliente;
        $servicio = new Servicio();
        $servicio->id_clie=$idcliente;
        $servicio->id_gep=$idGep;
        $servicio->id_proj=$idproyecto;
        $servicio->PDSI =$pdsi;
        $servicio->empresa = $empresa;
        $servicio->estado = 1;
        $servicio->save();

        echo json_encode($certificados,true);
    }
    public function apiCertPers(Request $request) {
        $dni = $request->dni;
        
        //Parametros de busqueda
        $certificado = $request->certificado;
        $designacion = $request->designacion;
        $equipo = $request->equipo;
        $normativa = $request->normativa;
        $nivel = $request->nivel;
        $estado = $request->estado;
        //dd($estado);
        $hoy = Carbon::today();
        //dd($hoy);
        //$idproyecto = $request->proyecto;
        if($estado==1){
        $certificados = Certificado::join('personas','certificados.idpersona','=','personas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('certificados.id','certificados.idusuario','certificados.pdsi','certificados.persona','certificados.empresa','certificados.certificado','certificados.indi_mayo_21to',
        'certificados.designacion','certificados.equipo','certificados.level','certificados.horas','certificados.fecha_revalidacion','certificados.fecha_emision7',
        'certificados.fecha_expiracion','certificados.dias','certificados.normativa','certificados.proyecto_id',
        'personas.dni','designacions.id_curso','designacions.id_curso_mmg')->where('personas.dni','like',$dni)->where('certificados.certificado','like','%'.$certificado.'%')
        ->where('certificados.designacion','like','%'.$designacion.'%')->where('certificados.normativa','like','%'.$normativa.'%')
        ->where('certificados.level','like','%'.$nivel.'%')->where('certificados.fecha_expiracion','>',$hoy)->where('certificados.condicion','<>',0)->get();
        }
        else if ($estado==2){
            $hoy = Carbon::today();
            $fechaHoy = Carbon::today();
            $fin = $fechaHoy->addDay(90);
            //dd($hoy);
            $certificados = Certificado::join('personas','certificados.idpersona','=','personas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('certificados.id','certificados.idusuario','certificados.pdsi','certificados.persona','certificados.empresa','certificados.certificado','certificados.indi_mayo_21to',
        'certificados.designacion','certificados.equipo','certificados.level','certificados.horas','certificados.fecha_revalidacion','certificados.fecha_emision7',
        'certificados.fecha_expiracion','certificados.dias','certificados.normativa','certificados.proyecto_id',
        'personas.dni','designacions.id_curso','designacions.id_curso_mmg')->where('personas.dni','=',$dni)->where('certificados.certificado','like','%'.$certificado.'%')
        ->where('certificados.designacion','like','%'.$designacion.'%')->where('certificados.normativa','like','%'.$normativa.'%')
        ->where('certificados.level','like','%'.$nivel.'%')->where('certificados.fecha_expiracion','>',$hoy)->where('certificados.fecha_expiracion','<=',$fin)->where('certificados.condicion','<>',0)->get();
        }
        else if ($estado==3){
            $hoy = Carbon::today();
            $fechaHoy = Carbon::today();
            $fin = $fechaHoy->addDay(90);
            $certificados = Certificado::join('personas','certificados.idpersona','=','personas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('certificados.id','certificados.idusuario','certificados.pdsi','certificados.persona','certificados.empresa','certificados.certificado','certificados.indi_mayo_21to',
        'certificados.designacion','certificados.equipo','certificados.level','certificados.horas','certificados.fecha_revalidacion','certificados.fecha_emision7',
        'certificados.fecha_expiracion','certificados.dias','certificados.normativa','certificados.proyecto_id',
        'personas.dni','designacions.id_curso','designacions.id_curso_mmg')->where('personas.dni','=',$dni)->where('certificados.certificado','like','%'.$certificado.'%')
        ->where('certificados.designacion','like','%'.$designacion.'%')->where('certificados.normativa','like','%'.$normativa.'%')
        ->where('certificados.level','like','%'.$nivel.'%')->where('certificados.fecha_revalidacion','>',$hoy)->where('certificados.fecha_revalidacion','<=',$fin)->where('certificados.condicion','<>',0)->get();
        }
        else if ($estado==4){
            $certificados = Certificado::join('personas','certificados.idpersona','=','personas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('certificados.id','certificados.idusuario','certificados.pdsi','certificados.persona','certificados.empresa','certificados.certificado','certificados.indi_mayo_21to',
        'certificados.designacion','certificados.equipo','certificados.level','certificados.horas','certificados.fecha_revalidacion','certificados.fecha_emision7',
        'certificados.fecha_expiracion','certificados.dias','certificados.normativa','certificados.proyecto_id',
        'personas.dni','designacions.id_curso','designacions.id_curso_mmg')->where('personas.dni','=',$dni)->where('certificados.certificado','like','%'.$certificado.'%')
        ->where('certificados.designacion','like','%'.$designacion.'%')->where('certificados.normativa','like','%'.$normativa.'%')
        ->where('certificados.level','like','%'.$nivel.'%')->where('certificados.fecha_expiracion','<',$hoy)->where('certificados.condicion','<>',0)->get();
        }
        else{
            $certificados = Certificado::join('personas','certificados.idpersona','=','personas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('certificados.id','certificados.idusuario','certificados.pdsi','certificados.persona','certificados.empresa','certificados.certificado','certificados.indi_mayo_21to',
        'certificados.designacion','certificados.equipo','certificados.level','certificados.horas','certificados.fecha_revalidacion','certificados.fecha_emision7',
        'certificados.fecha_expiracion','certificados.dias','certificados.normativa','certificados.proyecto_id',
        'personas.dni','designacions.id_curso','designacions.id_curso_mmg')->where('personas.dni','=',$dni)->where('certificados.certificado','like','%'.$certificado.'%')
        ->where('certificados.designacion','like','%'.$designacion.'%')->where('certificados.normativa','like','%'.$normativa.'%')
        ->where('certificados.level','like','%'.$nivel.'%')->where('certificados.condicion','<>',0)->get();
        }
        
        echo json_encode($certificados,true);
    }
    public function apiCertEmpr(Request $request) {
        $idcliente = $request->cliente;
        //Parametros de busqueda
        $pdsi = $request->pdsi;
        $dni = $request->dni;
        $parti = $request->parti;
        $certificado = $request->certificado;
        $designacion = $request->designacion;
        $equipo = $request->equipo;
        $normativa = $request->normativa;
        $nivel = $request->nivel;
        $estado = $request->estado;
        //dd($estado);
        $hoy = Carbon::today();
        //$idproyecto = $request->proyecto;
        if($estado==1){
        $certificados = Certificado::join('personas','certificados.idpersona','=','personas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('certificados.id','certificados.idusuario','certificados.pdsi','certificados.persona','certificados.empresa','certificados.certificado',
        'certificados.designacion','certificados.equipo','certificados.level','certificados.horas','certificados.fecha_emision','certificados.fecha_emision7',
        'certificados.fecha_expiracion','certificados.dias','certificados.normativa','certificados.proyecto_id',
        'personas.dni','designacions.id_curso','designacions.id_curso_mmg')->where('certificados.cli_id','=',$idcliente)->where('certificados.pdsi','like','%'.$pdsi.'%')->where('certificados.persona','like','%'.$parti.'%')
        ->where('personas.dni','like','%'.$dni.'%')->where('certificados.certificado','like','%'.$certificado.'%')
        ->where('certificados.designacion','like','%'.$designacion.'%')/*->where('certificados.equipo','like','%'.$equipo.'%')*/->where('certificados.normativa','like','%'.$normativa.'%')
        ->where('certificados.level','like','%'.$nivel.'%')->where('certificados.fecha_expiracion','>',$hoy)->where('certificados.condicion','<>',0)->get();
        }
        else if($estado==2){
            $hoy = Carbon::today();
            $fechaHoy = Carbon::today();
            $fin = $fechaHoy->addDay(90);
            $certificados = Certificado::join('personas','certificados.idpersona','=','personas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('certificados.id','certificados.idusuario','certificados.pdsi','certificados.persona','certificados.empresa','certificados.certificado',
        'certificados.designacion','certificados.equipo','certificados.level','certificados.horas','certificados.fecha_emision','certificados.fecha_emision7',
        'certificados.fecha_expiracion','certificados.dias','certificados.normativa','certificados.proyecto_id',
        'personas.dni','designacions.id_curso','designacions.id_curso_mmg')->where('certificados.cli_id','=',$idcliente)->where('certificados.pdsi','like','%'.$pdsi.'%')->where('certificados.persona','like','%'.$parti.'%')
        ->where('personas.dni','like','%'.$dni.'%')->where('certificados.certificado','like','%'.$certificado.'%')
        ->where('certificados.designacion','like','%'.$designacion.'%')->where('certificados.normativa','like','%'.$normativa.'%')
        ->where('certificados.level','like','%'.$nivel.'%')->where('certificados.fecha_expiracion','>',$hoy)->where('certificados.fecha_expiracion','<=',$fin)->where('certificados.condicion','<>',0)->get();
        }
        else if($estado==3){
            $hoy = Carbon::today();
            $fechaHoy = Carbon::today();
            $fin = $fechaHoy->addDay(90);
            $certificados = Certificado::join('personas','certificados.idpersona','=','personas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('certificados.id','certificados.idusuario','certificados.pdsi','certificados.persona','certificados.empresa','certificados.certificado',
        'certificados.designacion','certificados.equipo','certificados.level','certificados.horas','certificados.fecha_emision','certificados.fecha_emision7',
        'certificados.fecha_expiracion','certificados.dias','certificados.normativa','certificados.proyecto_id',
        'personas.dni','designacions.id_curso','designacions.id_curso_mmg')->where('certificados.cli_id','=',$idcliente)->where('certificados.pdsi','like','%'.$pdsi.'%')->where('certificados.persona','like','%'.$parti.'%')
        ->where('personas.dni','like','%'.$dni.'%')->where('certificados.certificado','like','%'.$certificado.'%')
        ->where('certificados.designacion','like','%'.$designacion.'%')->where('certificados.normativa','like','%'.$normativa.'%')
        ->where('certificados.level','like','%'.$nivel.'%')->where('certificados.fecha_revalidacion','>',$hoy)->where('certificados.fecha_revalidacion','<=',$fin)->where('certificados.condicion','<>',0)->get();
        }
        else if($estado==4){
            $certificados = Certificado::join('personas','certificados.idpersona','=','personas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('certificados.id','certificados.idusuario','certificados.pdsi','certificados.persona','certificados.empresa','certificados.certificado',
        'certificados.designacion','certificados.equipo','certificados.level','certificados.horas','certificados.fecha_emision','certificados.fecha_emision7',
        'certificados.fecha_expiracion','certificados.dias','certificados.normativa','certificados.proyecto_id',
        'personas.dni','designacions.id_curso','designacions.id_curso_mmg')->where('certificados.cli_id','=',$idcliente)->where('certificados.pdsi','like','%'.$pdsi.'%')->where('certificados.persona','like','%'.$parti.'%')
        ->where('personas.dni','like','%'.$dni.'%')->where('certificados.certificado','like','%'.$certificado.'%')
        ->where('certificados.designacion','like','%'.$designacion.'%')->where('certificados.normativa','like','%'.$normativa.'%')
        ->where('certificados.level','like','%'.$nivel.'%')->where('certificados.fecha_expiracion','<',$hoy)->where('certificados.condicion','<>',0)->get();
        }
        else{
        $certificados = Certificado::join('personas','certificados.idpersona','=','personas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        select('certificados.id','certificados.idusuario','certificados.pdsi','certificados.persona','certificados.empresa','certificados.certificado',
        'certificados.designacion','certificados.equipo','certificados.level','certificados.horas','certificados.fecha_emision','certificados.fecha_emision7',
        'certificados.fecha_expiracion','certificados.dias','certificados.normativa','certificados.proyecto_id',
        'personas.dni','designacions.id_curso','designacions.id_curso_mmg')->where('certificados.cli_id','=',$idcliente)->where('certificados.pdsi','like','%'.$pdsi.'%')->where('certificados.persona','like','%'.$parti.'%')
        ->where('personas.dni','like','%'.$dni.'%')->where('certificados.certificado','like','%'.$certificado.'%')
        ->where('certificados.designacion','like','%'.$designacion.'%')->where('certificados.normativa','like','%'.$normativa.'%')
        ->where('certificados.level','like','%'.$nivel.'%')->where('certificados.condicion','<>',0)->get();
        }
        echo json_encode($certificados,true);
    }

    public function validacioneq(Request $request)
    {   //if(!$request->ajax()) return redirect('/');
        $ruc = preg_replace("/[^0-9]/", "", $request->ruc);
        $serie = $request->serie;
        $pdsi = $request->pdsi;
        
        $equipos = Equipo::select('id','idusuario','codigo_certificado','codigo_informe','fechaIspeccion',
            'fechaRecomendada','fechaEmision','tipoEquipo','marca','modeloEquipo','serie','ruc','cliente','pdsi','otro',
            'estado','capacidad','qr')->OrderBy('id','desc')->where('serie','=',$serie)->where('ruc','=',$ruc)->where('pdsi','=',$pdsi)->where('estado','=','1')->get();
        $cont = Equipo::select('id','idusuario','codigo_certificado','codigo_informe','fechaIspeccion',
        'fechaRecomendada','fechaEmision','tipoEquipo','marca','modeloEquipo','serie','ruc','cliente','pdsi','otro',
        'estado','capacidad','qr')->OrderBy('id','desc')->where('serie','=',$serie)->where('ruc','=',$ruc)->where('pdsi','=',$pdsi)->where('estado','=','1')->count();
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
