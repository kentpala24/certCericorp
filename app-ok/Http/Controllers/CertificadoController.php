<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Generator;
use App\Certificado;
use App\Persona;
use App\Lote;
use App\Tipo_Certificado;
use App\Emision;
use App\Carne;
use App\Designacion;
use App\Firma;
use App\Edicion;
use PDF;
use Illuminate\Support\Facades\Http;

class CertificadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listado(Request $request)
    {   $pdsi = $request->bpdsi;
        $empresa = $request->bempresa;
        $numero =preg_replace("/[^0-9]/", "", $request->bnumero);
        $npersona=$request->bnpersona;
        $apersona = $request->bapersona;
        $tipo_certificado=$request->btipo_certificado;
        $estadoEval=$request->bnestadoEval;
        $cantidad = Lote::where('id','<>','34')->where('id','<>','36')->orderBy('id','desc')->first();
        $pdsi_All = Http::get("http://api-atom.cicbla.com/api/cliente.php?pdsi");
        $pdsi_array_All = $pdsi_All->json();
        //dd($pdsi_array_All);
        if($pdsi=='' && $empresa=='' && $numero=='' && $npersona=='' && $apersona=='' && $tipo_certificado==''  && $estadoEval==''){
        $certificados = Certificado::join('users','certificados.idusuario','=','users.id')->
        join('personas','certificados.idpersona','=','personas.id')->
        join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
        join('lotes','certificados.idlote','=','lotes.id')->
        join('firmas','certificados.idfirma','=','firmas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        join('carnes','certificados.id','=','carnes.idcertificado')->
        select('users.nombre as usuario_nombre','users.apellido as usuario_apellido','personas.id as idpersona','personas.nombre','personas.apellido','personas.dni',
        'lotes.id as idlote','lotes.nombre as nombre_lote','lotes.numero','certificados.id','certificados.pdsi','certificados.empresa','certificados.certificado',
        'certificados.iddesignacion','certificados.designacion as designacioncert','designacions.designacion_ingles as designacion','designacions.identifica','certificados.equipo','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','certificados.level','certificados.horas',
        'certificados.normativa','certificados.toneladas','certificados.qr','certificados.ip','certificados.condicion',
        'certificados.fecha_emision','certificados.fecha_emision2','certificados.fecha_emision3','certificados.fecha_emision4'
        ,'certificados.fecha_emision5','certificados.fecha_emision6','certificados.fecha_emision7','certificados.persona',
        'certificados.cond_equipo','certificados.dias','certificados.estado_edi','certificados.fecha_revalidacion','certificados.fecha_expiracion',
        'certificados.description','certificados.cabecera','certificados.fecha','certificados.proyecto_id','certificados.cli_id','certificados.id_evaluacion',
        'firmas.id as idfirma','firmas.nombre as firma_nombre','carnes.id as idcarne','carnes.estado','carnes.designacion_espanol as designacion_espanol',
        'carnes.normativa_espanol as normativaes','carnes.equipo_espanol as equipoes','carnes.nombrescarne','carnes.empresacarne','carnes.designacioncarne','carnes.fechacarne')->where('certificados.sede','=','1')
        ->OrderBy('id','desc')->paginate(70);
      }
        else{
          $certificados = Certificado::join('users','certificados.idusuario','=','users.id')->
        join('personas','certificados.idpersona','=','personas.id')->
        join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
        join('lotes','certificados.idlote','=','lotes.id')->
        join('firmas','certificados.idfirma','=','firmas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        join('carnes','certificados.id','=','carnes.idcertificado')->
        select('users.nombre as usuario_nombre','users.apellido as usuario_apellido','personas.id as idpersona','personas.nombre','personas.apellido','personas.dni',
        'lotes.id as idlote','lotes.nombre as nombre_lote','lotes.numero','certificados.id','certificados.pdsi','certificados.empresa','certificados.certificado',
        'certificados.iddesignacion','certificados.designacion as designacioncert','designacions.designacion_ingles as designacion','designacions.identifica','certificados.equipo','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','certificados.level','certificados.horas',
        'certificados.normativa','certificados.toneladas','certificados.qr','certificados.ip','certificados.condicion',
        'certificados.fecha_emision','certificados.fecha_emision2','certificados.fecha_emision3','certificados.fecha_emision4'
        ,'certificados.fecha_emision5','certificados.fecha_emision6','certificados.fecha_emision7','certificados.persona',
        'certificados.cond_equipo','certificados.dias','certificados.fecha_revalidacion','certificados.fecha_expiracion',
        'certificados.description','certificados.cabecera','certificados.fecha','certificados.proyecto_id','certificados.cli_id','certificados.id_evaluacion',
        'firmas.id as idfirma','firmas.nombre as firma_nombre','carnes.id as idcarne','carnes.estado','carnes.designacion_espanol as designacion_espanol',
        'carnes.normativa_espanol as normativaes','carnes.equipo_espanol as equipoes','carnes.nombrescarne','carnes.empresacarne','carnes.designacioncarne','carnes.fechacarne')->where('certificados.sede','=','1')
          ->where('certificados.pdsi', 'like', '%'.$pdsi.'%')->where('certificados.empresa', 'like', '%'.$empresa.'%')
          ->where('certificados.certificado', 'like', '%'.$numero.'%')->where('personas.nombre', 'like', '%'.$npersona.'%')
          ->where('personas.apellido', 'like', '%'.$apersona.'%')->where('certificados.designacion', 'like', '%'.$tipo_certificado.'%')
          ->where('certificados.id_evaluacion', 'like', '%'.$estadoEval.'%')
          ->OrderBy('id','desc')->paginate(70);
          //$stock = Lote::All()->orderByDesc('id');
          //dd($stock);
        }
        return [
            'pagination' => [
                'total'         => $certificados->total(),
                'current_page'  => $certificados->currentPage(),
                'per_page'      => $certificados->perPage(),
                'last_page'     => $certificados->lastPage(),
                'from'          => $certificados->firstItem(),
                'to'            => $certificados->lastItem(),
            ],
            'certificados'  =>  $certificados,
            'status_certificados' => $cantidad,
            'pdsi_all' => $pdsi_array_All
        ];
    }
    public function listado2(Request $request)
    {   $pdsi = $request->bpdsi;
        $empresa = $request->bempresa;
        $numero =preg_replace("/[^0-9]/", "", $request->bnumero);
        $npersona=$request->bnpersona;
        $apersona = $request->bapersona;
        $tipo_certificado=$request->btipo_certificado;
        if($pdsi=='' && $empresa=='' && $numero=='' && $npersona=='' && $apersona=='' && $tipo_certificado==''){
        $certificados = Certificado::join('users','certificados.idusuario','=','users.id')->
        join('personas','certificados.idpersona','=','personas.id')->
        join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
        join('lotes','certificados.idlote','=','lotes.id')->
        join('firmas','certificados.idfirma','=','firmas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        join('carnes','certificados.id','=','carnes.idcertificado')->
        join('edicions','certificados.id','=','edicions.idcertificado')->
        select('users.nombre as usuario_nombre','users.apellido as usuario_apellido','personas.id as idpersona','personas.nombre','personas.apellido','personas.dni',
        'lotes.id as idlote','lotes.nombre as nombre_lote','lotes.numero','certificados.id','certificados.pdsi','certificados.empresa','certificados.certificado',
        'certificados.iddesignacion','certificados.designacion as designacioncert','designacions.designacion_ingles as designacion','designacions.identifica','certificados.equipo','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','certificados.level','certificados.horas',
        'certificados.normativa','certificados.qr','certificados.ip','certificados.condicion',
        'certificados.fecha_emision','certificados.fecha_emision2','certificados.fecha_emision3','certificados.fecha_emision4'
        ,'certificados.fecha_emision5','certificados.fecha_emision6','certificados.fecha_emision7','certificados.persona',
        'certificados.cond_equipo','certificados.dias','certificados.fecha_revalidacion','certificados.fecha_expiracion',
        'certificados.description','certificados.cabecera','certificados.fecha',
        'firmas.id as idfirma','firmas.nombre as firma_nombre','carnes.id as idcarne','carnes.estado','carnes.designacion_espanol as designacion_espanol',
        'carnes.normativa_espanol as normativaes','carnes.equipo_espanol as equipoes','carnes.nombrescarne','carnes.empresacarne','carnes.designacioncarne','carnes.fechacarne',
        'edicions.id as id_edicions','edicions.solicitante','edicions.revisor','edicions.nombre_empresa','edicions.designacion as edicions_designacion','edicions.otros','edicions.horas as edicions_horas','edicions.fecha_solicitud',
        'edicions.fecha_aprobacion','edicions.firma as edicions_firma','edicions.foto','edicions.carne','edicions.anulacion','edicions.cliente','edicions.comentario','edicions.condicion as edicions_condicion'
        )->where('edicions.condicion','>=','2')->where('certificados.sede','=','1')
        ->OrderBy('id','desc')->paginate(70);
      }
        else{
          $certificados = Certificado::join('users','certificados.idusuario','=','users.id')->
        join('personas','certificados.idpersona','=','personas.id')->
        join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
        join('lotes','certificados.idlote','=','lotes.id')->
        join('firmas','certificados.idfirma','=','firmas.id')->
        join('designacions','certificados.iddesignacion','=','designacions.id')->
        join('carnes','certificados.id','=','carnes.idcertificado')->
        select('users.nombre as usuario_nombre','users.apellido as usuario_apellido','personas.id as idpersona','personas.nombre','personas.apellido','personas.dni',
        'lotes.id as idlote','lotes.nombre as nombre_lote','lotes.numero','certificados.id','certificados.pdsi','certificados.empresa','certificados.certificado',
        'certificados.iddesignacion','certificados.designacion as designacioncert','designacions.designacion_ingles as designacion','designacions.identifica','certificados.equipo','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','certificados.level','certificados.horas',
        'certificados.normativa','certificados.qr','certificados.ip','certificados.condicion',
        'certificados.fecha_emision','certificados.fecha_emision2','certificados.fecha_emision3','certificados.fecha_emision4'
        ,'certificados.fecha_emision5','certificados.fecha_emision6','certificados.fecha_emision7','certificados.persona',
        'certificados.cond_equipo','certificados.dias','certificados.fecha_revalidacion','certificados.fecha_expiracion',
        'certificados.description','certificados.cabecera','certificados.fecha',
        'firmas.id as idfirma','firmas.nombre as firma_nombre','carnes.id as idcarne','carnes.estado','carnes.designacion_espanol as designacion_espanol',
        'carnes.normativa_espanol as normativaes','carnes.equipo_espanol as equipoes','carnes.nombrescarne','carnes.empresacarne','carnes.designacioncarne','carnes.fechacarne',
        'edicions.id as id_edicions','edicions.solicitante','edicions.revisor','edicions.nombre_empresa','edicions.designacion as edicions_designacion','edicions.otros','edicions.horas as edicions_horas','edicions.fecha_solicitud',
        'edicions.fecha_aprobacion','edicions.firma as edicions_firma','edicions.foto','edicions.carne','edicions.anulacion','edicions.cliente','edicions.comentario','edicions.condicion')
          ->where('certificados.pdsi', 'like', '%'.$pdsi.'%')->where('certificados.empresa', 'like', '%'.$empresa.'%')
          ->where('certificados.certificado', 'like', '%'.$numero.'%')->where('personas.nombre', 'like', '%'.$npersona.'%')->where('certificados.sede','=','1')
          ->where('personas.apellido', 'like', '%'.$apersona.'%')->where('certificados.designacion', 'like', '%'.$tipo_certificado.'%')
          
          ->OrderBy('id','desc')->paginate(70);
        }
        return [
            'pagination' => [
                'total'         => $certificados->total(),
                'current_page'  => $certificados->currentPage(),
                'per_page'      => $certificados->perPage(),
                'last_page'     => $certificados->lastPage(),
                'from'          => $certificados->firstItem(),
                'to'            => $certificados->lastItem(),
            ],
            'certificados'  =>  $certificados
        ];
    }
    
    public function certificadoPdf(Request $request,$id){
      //if(!$request->ajax()) return redirect('/');
      $qrcode = new Generator;
      $data = $qrcode->format('svg')->size(399)->color(40,40,40)->generate('Make me a QrCode!','../public/qrcodes/qrcode.svg');
      $certificados = Certificado::join('users','certificados.idusuario','=','users.id')->
        join('personas','certificados.idpersona','=','personas.id')->
        join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
        join('lotes','certificados.idlote','=','lotes.id')->
        join('firmas','certificados.idfirma','=','firmas.id')->
        select('users.nombre as usuario_nombre','users.apellido as usuario_apellido','personas.id as idpersona','personas.nombre','personas.apellido',
        'lotes.id as idlote','lotes.nombre as nombre_lote','lotes.numero','certificados.id','certificados.pdsi','certificados.empresa','certificados.certificado',
        'certificados.designacion','certificados.equipo','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','certificados.level','certificados.horas',
        'certificados.normativa','certificados.qr','certificados.ip','certificados.condicion',
        'certificados.fecha_emision','certificados.fecha_emision2','certificados.fecha_emision3','certificados.fecha_emision4'
        ,'certificados.fecha_emision5','certificados.fecha_emision6','certificados.fecha_emision7','certificados.persona',
        'certificados.cond_equipo','certificados.dias','certificados.fecha_revalidacion','certificados.fecha_expiracion',
        'certificados.description','certificados.cabecera','certificados.fecha',
        'certificados.idfirma','certificados.id','firmas.nombre as firma_nombre','firmas.imagen')->where('certificados.id','=', $id)->OrderBy('certificado','desc')->get();
        $num= Certificado::findOrFail($id);
        PDF::SetProtection(array('modify','copy','print'), '', null, 0, null);
        PDF::SetTitle('Vista Previa');
        PDF::SetFont('times');
        PDF::setCellHeightRatio(1);
        PDF::AddPage();
        // -- set new background ---

        // get the current page break margin
        $bMargin = PDF::getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = PDF::getAutoPageBreak();
        // disable auto-page-break
        PDF::SetAutoPageBreak(false, 0);
        // set bacground image
        $nuevologo = 'img/nuevologo.png';
        $img_file = 'img/diploma-vistaprevia.jpg';
        $nuevoimg_file = 'img/nuevodiploma-vistaprevia.jpg';
        
        if($num->id>14450){
          PDF::Image($nuevoimg_file, 0, 0, 279, 216, '', '', '', false, 300, '', false, false, 0);
        }
        else{
          PDF::Image($nuevoimg_file, 0, 0, 279, 216, '', '', '', false, 300, '', false, false, 0);
        }
        PDF::Image($nuevologo, 113, 160, 50, 40, '', '', '', false, 300, '', false, false, 0);
        //PDF::Image($img_file, 0, 0, 279, 216, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        PDF::SetAutoPageBreak($auto_page_break, $bMargin);
        PDF::writeHTML(view('pdf.certificadopdf',['certificados' => $certificados,'data' => $data])->render(),true, true, true, true, '');       
        PDF::Output('PDF VISTA PREVIA', 'I');
    }
    public function certificadoPdfEmision(Request $request,$id){
      //if(!$request->ajax()) return redirect('/');
      $qrcode = new Generator;
      //$data = $qrcode->format('svg')->size(399)->color(40,40,40)->generate('Make me a QrCode!','../public/qrcodes/qrcode.svg');
      $certificados = Certificado::join('users','certificados.idusuario','=','users.id')->
        join('personas','certificados.idpersona','=','personas.id')->
        join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
        join('lotes','certificados.idlote','=','lotes.id')->
        join('firmas','certificados.idfirma','=','firmas.id')->
        select('users.nombre as usuario_nombre','users.apellido as usuario_apellido','personas.id as idpersona','personas.nombre','personas.apellido',
        'lotes.id as idlote','lotes.nombre as nombre_lote','lotes.numero','certificados.id','certificados.pdsi','certificados.empresa','certificados.certificado',
        'certificados.designacion','certificados.equipo','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','certificados.level','certificados.horas',
        'certificados.normativa','certificados.qr','certificados.ip','certificados.condicion',
        'certificados.fecha_emision','certificados.fecha_emision2','certificados.fecha_emision3','certificados.fecha_emision4'
        ,'certificados.fecha_emision5','certificados.fecha_emision6','certificados.fecha_emision7','certificados.persona',
        'certificados.cond_equipo','certificados.dias','certificados.fecha_revalidacion','certificados.fecha_expiracion',
        'certificados.description','certificados.cabecera','certificados.fecha',
        'certificados.idfirma','firmas.nombre as firma_nombre','firmas.imagen')->where('certificados.id','=', $id)->where('certificados.condicion','=', 2)->OrderBy('certificado','desc')->get();
        $num= Certificado::findOrFail($id);
        if($num->idfirma==3){
          PDF::SetProtection(array('copy'), '', null, 0, null);
        }
        else{
          PDF::SetProtection(array('copy','modify'), '', null, 0, null);
        }
        
        PDF::SetTitle($num->persona);
        PDF::SetFont('times');
        PDF::setCellHeightRatio(1);
        PDF::AddPage();
        // -- set new background ---

        // get the current page break margin
        $bMargin = PDF::getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = PDF::getAutoPageBreak();
        // disable auto-page-break
        PDF::SetAutoPageBreak(false, 0);
        // set bacground image
        
        $fondo='img/prueba1.jpg';
        
        $logo = 'img/logo.png';
        $nuevologo = 'img/nuevologo.png';
        $texto = 'img/texto.png';
        $encabezado = 'img/encabesado.png';
        $firma = Firma::findOrFail($num->idfirma);
        
        $firmacarne = 'storage/'.$firma->imagen;
        
        
        PDF::Image($fondo, 0, 0, 279, 216, '', '', '', false, 300, '', false, false, 0);
        $qr='qrcodes/'.$num->qr;
        PDF::ImageSVG($qr, 220, 25, 35, 35, '', '', '', false, 300, '', false, false, 0);

        PDF::Image($firmacarne, 173, 150.1, 65, 47, '', '', '', false, 300, '', false, false, 0);
        
        if($num->certificado>20805){
            PDF::Image($nuevologo, 110, 160, 55, 40, '', '', '', false, 300, '', false, false, 0);
        }
        else{
            PDF::Image($logo, 115, 155, 45, 40, '', '', '', false, 300, '', false, false, 0);
        }
        
        //PDF::Image($logo, 115, 155, 45, 40, '', '', '', false, 300, '', false, false, 0);
        PDF::Image($texto, 145, 114.5, 111.5, 16.5, '', '', '', false, 300, '', false, false, 0);
        PDF::Image($encabezado, 46, 25, 190, 87.3, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        PDF::SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        PDF::setPageMark();
        PDF::setPrintHeader(false);
        PDF::SetFooterMargin(0);
        PDF::setPrintFooter(false);
        PDF::writeHTML(view('pdf.certificadopdfEmision',['certificados' => $certificados])->render());
        
        $filename = 'P-'.$num->certificado.' '.$num->persona.'.pdf';
        
        PDF::addEmptySignatureAppearance(40, 33, 45, 20);
        PDF::setFont('times', '', 12);
        if($num->estado_edi==0){
          PDF::text(40,52,"Doc.P-$num->certificado.$num->estado_edi");
        }
        else{
          $estado_anterior=$num->estado_edi-1;
          PDF::text(40,52,"Doc.P-$num->certificado.$num->estado_edi");
          PDF::text(40,56,"Replace to Doc.P-$num->certificado.$estado_anterior");
        }
        //PDF::text(39,189,"EP-F-08 V.02");
        
        $version =  'img/certificadoversion.png';
            if($num->certificado>20805){
                PDF::Image($version, 40, 189.5, 20, '', '', '', '', false, 300, '', false, false, 0);
            } 
            else{
                
            }
        
        PDF::Output($filename, 'I');
       



/*
        $pdf = \PDF::loadView('pdf.certificadopdfEmision',['certificados' => $certificados,'data' => $data])->setPaper('letter', 'landscape');
        ini_set("memory_limit","128M"); 
        $num= Certificado::findOrFail($id);
        $name='P-'.$num->certificado.' '.$num->persona.'.pdf';
        return $pdf->stream($name,array("Attachment" => 0));
        */
    }
    public function certificadoPdfEmisionSS(Request $request,$id){
      //if(!$request->ajax()) return redirect('/');
      $qrcode = new Generator;
      $data = $qrcode->format('svg')->size(399)->color(40,40,40)->generate('Make me a QrCode!','../public/qrcodes/qrcode.svg');
      $certificados = Certificado::join('users','certificados.idusuario','=','users.id')->
        join('personas','certificados.idpersona','=','personas.id')->
        join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
        join('lotes','certificados.idlote','=','lotes.id')->
        join('firmas','certificados.idfirma','=','firmas.id')->
        select('users.nombre as usuario_nombre','users.apellido as usuario_apellido','personas.id as idpersona','personas.nombre','personas.apellido',
        'lotes.id as idlote','lotes.nombre as nombre_lote','lotes.numero','certificados.id','certificados.pdsi','certificados.empresa','certificados.certificado',
        'certificados.designacion','certificados.equipo','tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','certificados.level','certificados.horas',
        'certificados.normativa','certificados.qr','certificados.ip','certificados.condicion',
        'certificados.fecha_emision','certificados.fecha_emision2','certificados.fecha_emision3','certificados.fecha_emision4'
        ,'certificados.fecha_emision5','certificados.fecha_emision6','certificados.fecha_emision7','certificados.persona',
        'certificados.cond_equipo','certificados.dias','certificados.fecha_revalidacion','certificados.fecha_expiracion',
        'certificados.description','certificados.cabecera','certificados.fecha',
        'firmas.id as idfirma','firmas.nombre as firma_nombre','firmas.imagen')->where('certificados.id','=', $id)->where('certificados.condicion','=', 2)->OrderBy('certificado','desc')->get();
        $pdf = \PDF::loadView('pdf.certificadopdfEmision',['certificados' => $certificados,'data' => $data])->setPaper('letter', 'landscape');
        ini_set("memory_limit","128M"); 
        $num= Certificado::findOrFail($id);
        $name='P-'.$num->certificado.' '.$num->persona.'.pdf';
        return $pdf->stream($name,array("Attachment" => 0));
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
            // Si se utiliza un proxy, esto nos daria la IP del proxy
            // y no la IP real del usuario.
            $ip = $_SERVER['REMOTE_ADDR'];
          }
        if(!$request->ajax()) return redirect('/');
        $certificado = new Certificado();
        $certificado->idusuario=Auth::user()->id;
        $certificado->idpersona=$request->persona_id;
        //Agregar pdsi y cli_id and prj_id
        $prj_id=$request->prj_id;
        $proyecto = Http::get("http://api-atom.cicbla.com/api/cliente.php?proyecto=$prj_id");
        $proyectoArray = $proyecto->json();
        $certificado->proyecto_id = $prj_id;
        //dd($proyectoArray[0]['prj_id']);
        $certificado->cli_id = $proyectoArray[0]['cli_id'];
        $certificado->pdsi= $proyectoArray[0]['nro_pdsi'];
        //dd($proyectoArray->cli_id);
        //Fin
        $certificado->idfirma=$request->firma_id;
        $certificado->idlote=$request->lote_id;
        //
        $persona = Persona::findOrFail($request->persona_id);
        $certificado->persona=$persona->nombre.' '.$persona->apellido;
        //
        //$certificado->pdsi=$request->pdsi;
        $certificado->empresa=$request->empresa;
        $certificado->cabecera="<h1 class='contenido' style=\"font-size:19pt;\">$persona->nombre $persona->apellido<br><font style=\"font-size:18pt;\">$request->empresa</font></h1>";
        $certificado->ip=$ip;
        //
        $certificado->certificado=0;
        //
        $certificado->qr='qr';
        //Fechas de Certificado
        if($request->level=='Basic Level'){
          if($request->tipo_certificado_id!=8){
            //NORMAL
            $fecha_antes = $request->fecha_emision7;
            $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
            $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
            $certificado->fecha_expiracion=$fecha_expiracion;
            }
            else{
            //NORMAL
            $fecha_antes = $request->fecha_emision7;
            $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
            $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
            $certificado->fecha_expiracion=$fecha_expiracion;
            }
          //Fecha Formateada - Emisión
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7=date('d',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));
          $fec_emi="$mes7 $dia7, $ano7";
          //Fecha Formateada - Expiración
          $mese=date('F',strtotime($fecha_expiracion));
          $diae=date('d',strtotime($fecha_expiracion));
          $anoe=date('Y',strtotime($fecha_expiracion));
          $fec_exp="$mese $diae, $anoe";
          //Ingresar Fecha para certificado
          $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
        }
        elseif($request->level=='Standard Level'){
          if($request->tipo_certificado_id!=8){
            //NORMAL
            $fecha_antes = $request->fecha_emision7;
            $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
            $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
            $certificado->fecha_expiracion=$fecha_expiracion;
            }
            else{
            //NORMAL
            $fecha_antes = $request->fecha_emision7;
            $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
            $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
            $certificado->fecha_expiracion=$fecha_expiracion;
            }
          //Fecha Formateada - Emisión
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7=date('d',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));
          $fec_emi="$mes7 $dia7, $ano7";
          //Fecha Formateada - Expiración
          $mese=date('F',strtotime($fecha_expiracion));
          $diae=date('d',strtotime($fecha_expiracion));
          $anoe=date('Y',strtotime($fecha_expiracion));
          $fec_exp="$mese $diae, $anoe";
          //Ingresar Fecha para certificado
          $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
        }
        elseif($request->level=='Intermediate Level'){
          $fecha_antes = $request->fecha_emision7;
          $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
          $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
          //Fecha Formateada - Emisión
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7=date('d',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));
          $fec_emi="$mes7 $dia7, $ano7";
          //Fecha Formateada - Expiración
          $mese=date('F',strtotime($fecha_expiracion));
          $diae=date('d',strtotime($fecha_expiracion));
          $anoe=date('Y',strtotime($fecha_expiracion));
          $fec_exp="$mese $diae, $anoe";
          
          if($request->tipo_certificado_id<7){
            $fecha_re = $request->fecha_emision7;
            $fec_reevaluacion = strtotime ('+1 year -1 day', strtotime($fecha_re));
            $fec_reevaluacion = date('Y-m-d',$fec_reevaluacion);
            $certificado->fecha_revalidacion=$fec_reevaluacion;
            //Fecha Formateada - Reevaluación
            $mesr=date('F',strtotime($fec_reevaluacion));
            $diar=date('d',strtotime($fec_reevaluacion));
            $anor=date('Y',strtotime($fec_reevaluacion));
            $fec_rev="$mesr $diar, $anor";
            $certificado->fecha_expiracion=$fecha_expiracion;
            $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;REVALIDATE: $fec_rev<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_exp";
          }
          else{
          $certificado->fecha_expiracion=$fecha_expiracion;
          $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
          }
        }
        elseif($request->level=='Level 1'){
          $fecha_antes = $request->fecha_emision7;
          $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
          $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
          //$certificado->fecha_emision7=$fecha_expiracion;
          //Fecha Formateada - Emisión
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7=date('d',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));
          $fec_emi="$mes7 $dia7, $ano7";
          
          //Fecha Formateada - Expiración
          $mese=date('F',strtotime($fecha_expiracion));
          $diae=date('d',strtotime($fecha_expiracion));
          $anoe=date('Y',strtotime($fecha_expiracion));
          $fec_exp="$mese $diae, $anoe";
          $certificado->fecha_expiracion=$fecha_expiracion;
          $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
        }
        elseif($request->level=='Level I'){
          $fecha_antes = $request->fecha_emision7;
          $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
          $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
          //$certificado->fecha_emision7=$fecha_expiracion;
          //Fecha Formateada - Emisión
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7=date('d',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));
          $fec_emi="$mes7 $dia7, $ano7";
          //Fecha Formateada - Expiración
          $mese=date('F',strtotime($fecha_expiracion));
          $diae=date('d',strtotime($fecha_expiracion));
          $anoe=date('Y',strtotime($fecha_expiracion));
          $fec_exp="$mese $diae, $anoe";
          $certificado->fecha_expiracion=$fecha_expiracion;
          $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
        }
        else{
          $fecha_antes = $request->fecha_emision7;
          $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
          $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
          //$certificado->fecha_emision7=$fecha_expiracion;
          $certificado->fecha_expiracion=$fecha_expiracion;
          $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
        }
        
        // Designación Certificado
        $certificado->idtipo_certificado=$request->tipo_certificado_id;
        $tipo = Tipo_Certificado::findOrFail($request->tipo_certificado_id);
        if($request->tipo_certificado_id == 8){
          $request->level = "";
        }
        $designacion = Designacion::findOrFail($request->iddesignacion);
        //Campos a condicionar
        $certificado->designacion=$designacion->designacion_ingles;
        $certificado->iddesignacion=$request->iddesignacion;
        $certificado->level=$request->level;
        //Campos a condicionar
        $certificado->horas=$request->horas;
        $certificado->normativa=$request->normativa;
        $certificado->cond_equipo=$request->cond_equipo;
        
        $certificado->dias=$request->dias;
        //fechas
        if($request->dias==1){
          $certificado->fecha_emision7=$request->fecha_emision7;
          //fecha fin
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7a=date('d',strtotime($request->fecha_emision7));
          $indice7a=date('S',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));
          $datofecha = "$mes7 $dia7a<sup>$indice7a</sup>, $ano7";
        }
        elseif($request->dias==2){
          //fecha 1
          $certificado->fecha_emision=$request->fecha_emision;
          $mes1=date('F',strtotime($request->fecha_emision));
          $dia1=date('d',strtotime($request->fecha_emision));
          $indice1=date('S',strtotime($request->fecha_emision));
          $ano1=date('Y',strtotime($request->fecha_emision));
          //fecha fin
          $certificado->fecha_emision7=$request->fecha_emision7;
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7=date('d',strtotime($request->fecha_emision7));
          $indice7a=date('S',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));
          if($mes1==$mes7){
            $datofecha = "$mes7 $dia1<sup>$indice1</sup> & $dia7<sup>$indice7a</sup>, $ano7";
          }
          else{
            if($ano1==$ano7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
            else{
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
          }

        }
        elseif($request->dias==3){
          
          //fecha 1
          $certificado->fecha_emision=$request->fecha_emision;
          $mes1=date('F',strtotime($request->fecha_emision));
          $dia1=date('d',strtotime($request->fecha_emision));
          $indice1=date('S',strtotime($request->fecha_emision));
          $ano1=date('Y',strtotime($request->fecha_emision));
          //fecha 2
          $certificado->fecha_emision2=$request->fecha_emision2;
          $mes2=date('F',strtotime($request->fecha_emision2));
          $dia2=date('d',strtotime($request->fecha_emision2));
          $indice2=date('S',strtotime($request->fecha_emision2));
          $ano2=date('Y',strtotime($request->fecha_emision2));
          //fecha fin
          $certificado->fecha_emision7=$request->fecha_emision7;
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7=date('d',strtotime($request->fecha_emision7));
          $indice7a=date('S',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));
          if($ano1==$ano2 && $ano2==$ano7){
            if($mes1==$mes7 && $mes2==$mes1){
              $datofecha = "$mes7 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup> & $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes1==$mes2 && $mes2!=$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes1!=$mes2 && $mes2==$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup> & $dia7<sup>$indice7a</sup>, $ano7";
            }
            else{
                $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";  
            }
          }
          elseif($ano1==$ano2 && $ano2!=$ano7){
            if($mes1==$mes2){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $ano1 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes1!=$mes2){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $ano1 & $dia7<sup>$indice7a</sup>, $ano7";
            }
          }
          elseif($ano1!=$ano2 && $ano2==$ano7){
            if($mes2==$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup> & $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes2!=$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup> <br/> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
          }
          
        }
        elseif($request->dias==4){
          //fecha 1
          $certificado->fecha_emision=$request->fecha_emision;
          $mes1=date('F',strtotime($request->fecha_emision));
          $dia1=date('d',strtotime($request->fecha_emision));
          $indice1=date('S',strtotime($request->fecha_emision));
          $ano1=date('Y',strtotime($request->fecha_emision));
          //fecha 2
          $certificado->fecha_emision2=$request->fecha_emision2;
          $mes2=date('F',strtotime($request->fecha_emision2));
          $dia2=date('d',strtotime($request->fecha_emision2));
          $indice2=date('S',strtotime($request->fecha_emision2));
          $ano2=date('Y',strtotime($request->fecha_emision2));
          //fecha 3
          $certificado->fecha_emision3=$request->fecha_emision3;
          $mes3=date('F',strtotime($request->fecha_emision3));
          $dia3=date('d',strtotime($request->fecha_emision3));
          $indice3=date('S',strtotime($request->fecha_emision3));
          $ano3=date('Y',strtotime($request->fecha_emision3));
          //fecha fin
          $certificado->fecha_emision7=$request->fecha_emision7;
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7=date('d',strtotime($request->fecha_emision7));
          $indice7a=date('S',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));

          if($ano1==$ano7){
            if($mes1==$mes2 && $mes2==$mes3 && $mes3==$mes7){
              $datofecha = "$mes7 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes1==$mes3 && $mes3!=$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes1==$mes2 && $mes2!=$mes3 && $mes3==$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $mes7 $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes1!=$mes2 && $mes2==$mes3 && $mes3==$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes7 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
            }
          }
          elseif($ano1==$ano2 && $ano2==$ano3 && $ano3!=$ano7){
            if($mes1==$mes2 && $mes2==$mes3){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }

            elseif($mes1==$mes2 && $mes2!=$mes3){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes1!=$mes2 && $mes2==$mes3){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes1!=$mes2 && $mes2!=$mes3){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
          }
          elseif($ano1==$ano2 && $ano2!=$ano3 && $ano3==$ano7){
            if($mes1==$mes2 && $mes3==$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $ano2, $mes7  $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
            }

            elseif($mes1==$mes2 && $mes3!=$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $ano2, $mes3 $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes1!=$mes2 && $mes3==$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $ano2, $mes3 $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes1!=$mes2 && $mes3!=$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $ano2, $mes3 $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }}
          elseif($ano1!=$ano2 && $ano2==$ano3 && $ano3==$ano7){
            if($mes2==$mes3 && $mes3==$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes2!=$mes3 && $mes3==$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes2==$mes3 && $mes3!=$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
            elseif($mes2!=$mes3 && $mes3!=$mes7){
              $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
            }
          }  
          }
        elseif($request->dias==5){
          
          //fecha 1
          $certificado->fecha_emision=$request->fecha_emision;
          $mes1=date('F',strtotime($request->fecha_emision));
          $dia1=date('d',strtotime($request->fecha_emision));
          $indice1=date('S',strtotime($request->fecha_emision));
          $ano1=date('Y',strtotime($request->fecha_emision));
          $fecha1 ="$mes1 $dia1<sup>$indice1</sup>, $ano1";
          //fecha 2
          $certificado->fecha_emision2=$request->fecha_emision2;
          $mes2=date('F',strtotime($request->fecha_emision2));
          $dia2=date('d',strtotime($request->fecha_emision2));
          $indice2=date('S',strtotime($request->fecha_emision2));
          $ano2=date('Y',strtotime($request->fecha_emision2));
          $fecha2 ="$mes2 $dia2<sup>$indice2</sup>, $ano2";
          //fecha 3
          $certificado->fecha_emision3=$request->fecha_emision3;
          $mes3=date('F',strtotime($request->fecha_emision3));
          $dia3=date('d',strtotime($request->fecha_emision3));
          $indice3=date('S',strtotime($request->fecha_emision3));
          $ano3=date('Y',strtotime($request->fecha_emision3));
          $fecha3 ="$mes3 $dia3<sup>$indice3</sup>, $ano3";
          //fecha 4
          $certificado->fecha_emision4=$request->fecha_emision4;
          $mes4=date('F',strtotime($request->fecha_emision4));
          $dia4=date('d',strtotime($request->fecha_emision4));
          $indice4=date('S',strtotime($request->fecha_emision4));
          $ano4=date('Y',strtotime($request->fecha_emision4));
          $fecha4 ="$mes4 $dia4<sup>$indice4</sup>, $ano4";
          //fecha fin
          $certificado->fecha_emision7=$request->fecha_emision7;
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7=date('d',strtotime($request->fecha_emision7));
          $indice7a=date('S',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));
          $fecha7 ="$mes7 $dia7<sup>$indice7</sup>, $ano7";

          $datofecha="$fecha1 , $fecha2, $fecha3, $fecha4 & $fecha7";
        }
        elseif($request->dias==6){
          //fecha 1
          $certificado->fecha_emision=$request->fecha_emision;
          $mes1=date('F',strtotime($request->fecha_emision));
          $dia1=date('d',strtotime($request->fecha_emision));
          $indice1=date('S',strtotime($request->fecha_emision));
          $ano1=date('Y',strtotime($request->fecha_emision));
          $fecha1 ="$mes1 $dia1<sup>$indice1</sup>, $ano1";
          //fecha 2
          $certificado->fecha_emision2=$request->fecha_emision2;
          $mes2=date('F',strtotime($request->fecha_emision2));
          $dia2=date('d',strtotime($request->fecha_emision2));
          $indice2=date('S',strtotime($request->fecha_emision2));
          $ano2=date('Y',strtotime($request->fecha_emision2));
          $fecha2 ="$mes2 $dia2<sup>$indice2</sup>, $ano2";
          //fecha 3
          $certificado->fecha_emision3=$request->fecha_emision3;
          $mes3=date('F',strtotime($request->fecha_emision3));
          $dia3=date('d',strtotime($request->fecha_emision3));
          $indice3=date('S',strtotime($request->fecha_emision3));
          $ano3=date('Y',strtotime($request->fecha_emision3));
          $fecha3 ="$mes3 $dia3<sup>$indice3</sup>, $ano3";
          //fecha 4
          $certificado->fecha_emision4=$request->fecha_emision4;
          $mes4=date('F',strtotime($request->fecha_emision4));
          $dia4=date('d',strtotime($request->fecha_emision4));
          $indice4=date('S',strtotime($request->fecha_emision4));
          $ano4=date('Y',strtotime($request->fecha_emision4));
          $fecha4 ="$mes4 $dia4<sup>$indice4</sup>, $ano4";
          //fecha 5
          $certificado->fecha_emision5=$request->fecha_emision5;
          $mes5=date('F',strtotime($request->fecha_emision5));
          $dia5=date('d',strtotime($request->fecha_emision5));
          $indice5=date('S',strtotime($request->fecha_emision5));
          $ano5=date('Y',strtotime($request->fecha_emision5));
          $fecha5 ="$mes5 $dia5<sup>$indice5</sup>, $ano5";
          //fecha fin
          $certificado->fecha_emision7=$request->fecha_emision7;
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7=date('d',strtotime($request->fecha_emision7));
          $indice7a=date('S',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));
          $fecha7 ="$mes7 $dia7<sup>$indice7</sup>, $ano7";
          $datofecha="$fecha1 , $fecha2, $fecha3, $fecha4, $fecha5 & $fecha7";
        }
        elseif($request->dias==7){
          $certificado->fecha_emision=$request->fecha_emision;
          $certificado->fecha_emision2=$request->fecha_emision2;
          $certificado->fecha_emision3=$request->fecha_emision3;
          $certificado->fecha_emision4=$request->fecha_emision4;
          $certificado->fecha_emision5=$request->fecha_emision5;
          $certificado->fecha_emision6=$request->fecha_emision6;
          $certificado->fecha_emision7=$request->fecha_emision7;
          //fecha 1
          $certificado->fecha_emision=$request->fecha_emision;
          $mes1=date('F',strtotime($request->fecha_emision));
          $dia1=date('d',strtotime($request->fecha_emision));
          $indice1=date('S',strtotime($request->fecha_emision));
          $ano1=date('Y',strtotime($request->fecha_emision));
          $fecha1 ="$mes1 $dia1<sup>$indice1</sup>, $ano1";
          //fecha 2
          $certificado->fecha_emision2=$request->fecha_emision2;
          $mes2=date('F',strtotime($request->fecha_emision2));
          $dia2=date('d',strtotime($request->fecha_emision2));
          $indice2=date('S',strtotime($request->fecha_emision2));
          $ano2=date('Y',strtotime($request->fecha_emision2));
          $fecha2 ="$mes2 $dia2<sup>$indice2</sup>, $ano2";
          //fecha 3
          $certificado->fecha_emision3=$request->fecha_emision3;
          $mes3=date('F',strtotime($request->fecha_emision3));
          $dia3=date('d',strtotime($request->fecha_emision3));
          $indice3=date('S',strtotime($request->fecha_emision3));
          $ano3=date('Y',strtotime($request->fecha_emision3));
          $fecha3 ="$mes3 $dia3<sup>$indice3</sup>, $ano3";
          //fecha 4
          $certificado->fecha_emision4=$request->fecha_emision4;
          $mes4=date('F',strtotime($request->fecha_emision4));
          $dia4=date('d',strtotime($request->fecha_emision4));
          $indice4=date('S',strtotime($request->fecha_emision4));
          $ano4=date('Y',strtotime($request->fecha_emision4));
          $fecha4 ="$mes4 $dia4<sup>$indice4</sup>, $ano4";
          //fecha 5
          $certificado->fecha_emision5=$request->fecha_emision5;
          $mes5=date('F',strtotime($request->fecha_emision5));
          $dia5=date('d',strtotime($request->fecha_emision5));
          $indice5=date('S',strtotime($request->fecha_emision5));
          $ano5=date('Y',strtotime($request->fecha_emision5));
          $fecha5 ="$mes5 $dia5<sup>$indice5</sup>, $ano5";
          //fecha 6
          $certificado->fecha_emision6=$request->fecha_emision6;
          $mes6=date('F',strtotime($request->fecha_emision6));
          $dia6=date('d',strtotime($request->fecha_emision6));
          $indice6=date('S',strtotime($request->fecha_emision6));
          $ano6=date('Y',strtotime($request->fecha_emision6));
          $fecha6 ="$mes6 $dia6<sup>$indice6</sup>, $ano6";
          //fecha fin
          $certificado->fecha_emision7=$request->fecha_emision7;
          $mes7=date('F',strtotime($request->fecha_emision7));
          $dia7=date('d',strtotime($request->fecha_emision7));
          $indice7a=date('S',strtotime($request->fecha_emision7));
          $ano7=date('Y',strtotime($request->fecha_emision7));
          $fecha7 ="$mes7 $dia7<sup>$indice7</sup>, $ano7";

          $datofecha="$fecha1 , $fecha2, $fecha3, $fecha4, $fecha5, $fecha6 & $fecha7";
        }
        else{
          $certificado->fecha_emision7='2020-09-11';
          $datofecha = '';
        }

      
        if($request->tipo_certificado_id == 12){
          $designacion_certificado = $designacion->designacion_ingles;
        }
        else{
          $designacion_certificado = "$designacion->designacion_ingles $tipo->nombre";
        }
        if($request->cond_equipo==1){ 
          $certificado->equipo=$request->equipo;
          $certificado->description="<b style=\"font-size:12pt;\">$designacion_certificado:
<br/> $request->equipo 
<br/>$request->level</b>
<br/> Under current aplicable code(s): $request->normativa 
<br/><font style=\"font-size:12pt;\">Training and examinations on $datofecha
<br/>($request->horas hours in total)</font>";
        }
        elseif($request->cond_equipo==0){ 
          
          $certificado->description="<b style=\"font-size:12pt;\">$designacion_certificado
<br/>$request->level</b>
<br/> Under current aplicable code(s): $request->normativa 
<br/><font style=\"font-size:12pt;\">Training and examinations on $datofecha
<br/>($request->horas hours in total)</font>";
        }
        
        elseif($request->cond_equipo==2){ 
          $certificado->equipo=$request->equipo;
          $certificado->description="<b style=\"font-size:12pt;\">$designacion_certificado:
<br/> $request->equipo 
<br/>$request->level</b>
<br/><font style=\"font-size:12pt;\">Training and examinations on $datofecha
<br/> Under recommendations: $request->normativa 
<br/>($request->horas hours in total)</font>";
        }
        else{
          $certificado->description="Datos Incorrectos";
        }
        
        
        $certificado->condicion='1';
        $certificado->toneladas=$request->toneladas;
        $certificado->save();

        //Carné
        $carne = new Carne();
        $carne->idusuario  = Auth::user()->id;
        $carne->iddesignacion=$designacion->id;
        $carne->idcertificado=$certificado->id;
        $carne->foto=$persona->imagen;
        $carne->designacion_espanol=$designacion->designacion_espanol;
        if($request->cond_equipo==2){
        $carne->equipo_espanol=$request->equipoes;
        $equipocarne=$request->equipoes;
        }
        else {
          $carne->equipo_espanol=$request->equipo;
          $equipocarne=$request->equipo;
        }
        $carne->normativa_espanol=$request->normativaes;
        $fechaEmisionC=date("d/m/Y", strtotime($request->fecha_emision7));
       
        $fechaVenceC=date("d/m/Y", strtotime($fecha_expiracion));
        if($request->level!='Intermediate Level'){
          if($request->tipo_certificado_id==5 || $request->tipo_certificado_id==6 || $request->tipo_certificado_id==12){
            $carne->reevaluacion=0;
          }
          

          $carne->fechacarne="<font style=\"font-size:8pt;\"><br/>
EMITIDO: $fechaEmisionC<br>
VENCE: $fechaVenceC</font>";

        }
        else {
          
          if($request->tipo_certificado_id==5 || $request->tipo_certificado_id==6){
            $carne->reevaluacion=1;
            $fechaRevalidC=date("d/m/Y", strtotime($fec_reevaluacion));
            $carne->fechacarne="<font style=\"font-size:8pt;\"><br/>
            EMITIDO: $fechaEmisionC<br>
            REVALIDAR: $fechaRevalidC</font>";
          }
          else {
            $carne->reevaluacion=0;
            $carne->fechacarne="<font style=\"font-size:8pt;\"><br/>
            EMITIDO: $fechaEmisionC<br>
            VENCE: $fechaVenceC</font>";
          }
         
        }
        $carne->nombrescarne="<font style=\"font-size:8pt;\">$persona->nombre $persona->apellido</font>";
        $carne->empresacarne="<font style=\"font-size:8pt;\">$request->empresa</font>";
        $desig='';
        switch($request->tipo_certificado_id){
          case 5: $desig='Operador';
              break;
          case 6: $desig='Aparejador';
              break;
          case 7: $desig='Supervisor';
              break;
          case 8: $desig='INSPECTOR';
              break;
          default: $desig='INSPECTOR';
              break;
        }
        
        $designacion = Designacion::findOrFail($request->iddesignacion);
        if($request->level=="Basic Level"){ $nivelcarne='Nivel Básico'; $carne->estado=0;}
    elseif($request->level=="Intermediate Level"){ 
      $nivelcarne='Nivel Intermedio';
      if($request->tipo_certificado_id==5 || $request->tipo_certificado_id==6){
        $carne->estado=1;}
      else{
        $carne->estado=0;
      }
           }
    elseif($request->level=="Level 1"){ $nivelcarne='Level 1';$carne->estado=0;}
    elseif($request->level=="Level I"){ $nivelcarne='Level 1';$carne->estado=0;}
    elseif($request->level=="Standard Level"){ $nivelcarne='Nivel Estándar';$carne->estado=0;}
    else{
      $nivelcarne='';
    }
        if($request->cond_equipo==0){
          if($request->tipo_certificado_id==8){
            $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$designacion->designacion_espanol $desig
      </font>";}
          elseif ($request->tipo_certificado_id==12) {
            $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$designacion->designacion_espanol 
      </font><br>
      <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";
          }
              else{
             $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$desig de $designacion->designacion_espanol 
      </font><br><br>
      <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";
              }
        }
        else{
        if($request->tipo_certificado_id==12) {
          $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$designacion->designacion_espanol </font>
          <br>
      <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";
        }
        else{
        $carne->designacioncarne="<font style=\"font-size:8pt;\"><br/>$desig de $designacion->designacion_espanol: 
<br/>$equipocarne</font><br><br>
<font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";}}
        
        
        
        $carne->save();
        
    
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
    public function updatead(Request $request){
      if(!$request->ajax()) return redirect('/');
      $certificado = Certificado::findOrFail($request->id);
      $certificado->idusuario=Auth::user()->id;
      if($request->description==""){

      }
      else{
        $certificado->description=$request->description;
      }
      if($request->fecha==""){
        
      }
      else{
        $certificado->fecha=$request->fecha;
      }
      if($request->cabecera==""){
        
      }
      else{
        $certificado->cabecera=$request->cabecera;
      }
      $certificado->save();

    }
    

    public function actualizarCarne(Request $request){
      if(!$request->ajax()) return redirect('/');
      $carne = Carne::findOrFail($request->id);
      $carne->idusuario=Auth::user()->id;
      $carne->nombrescarne=$request->nombrescarne;
      $carne->empresacarne=$request->empresacarne;
      $carne->designacioncarne=$request->designacioncarne;
      $carne->fechacarne=$request->fechacarne;
      if($request->foto==''){
        
      }
      else{
        $carne->foto=$request->foto;
      }
      $carne->save();
    }
    public function emitirCarne(Request $request){
      if(!$request->ajax()) return redirect('/');
      $carne = Carne::findOrFail($request->id);
      $carne->idusuario=Auth::user()->id;
      $carne->nombrescarne=$request->nombrescarne;
      $carne->empresacarne=$request->empresacarne;
      $carne->designacioncarne=$request->designacioncarne;
      $carne->fechacarne=$request->fechacarne;
      if($request->foto==''){

      }
      else{
        $carne->foto=$request->foto;
      }
      
      if($carne->estado==0){
        $carne->estado=2;
      }
      elseif($carne->estado==1){
        if($carne->reevaluacion==0){
          $carne->estado=2;
        }
        else{
          $carne->estado=3;
        }
        
      }
      $carne->save();
    }

    public function update(Request $request)
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
        // Si se utiliza un proxy, esto nos daria la IP del proxy
        // y no la IP real del usuario.
        $ip = $_SERVER['REMOTE_ADDR'];
      }
    if(!$request->ajax()) return redirect('/');
    $certificado = Certificado::findOrFail($request->id);
    $certificado->idusuario=Auth::user()->id;
    $certificado->idpersona=$request->persona_id;
    
    $certificado->idfirma=$request->firma_id;
    $certificado->idlote=$request->lote_id;
    //
    $persona = Persona::findOrFail($request->persona_id);
    $certificado->persona=$persona->nombre.' '.$persona->apellido;
    //
    //Agregar pdsi y cli_id and prj_id
    $prj_id=$request->prj_id;
    $proyecto = Http::get("http://api-atom.cicbla.com/api/cliente.php?proyecto=$prj_id");
    $proyectoArray = $proyecto->json();
    $certificado->proyecto_id = $prj_id;
    //dd($proyectoArray[0]['prj_id']);
    $certificado->cli_id = $proyectoArray[0]['cli_id'];
    $certificado->pdsi= $proyectoArray[0]['nro_pdsi'];
    //Fin
    //$certificado->pdsi=$request->pdsi;
    $certificado->empresa=$request->empresa;
    $certificado->cabecera="<h1 class='contenido' style=\"font-size:19pt;\">$persona->nombre $persona->apellido<br><font style=\"font-size:18pt;\">$request->empresa</font></h1>";
    $certificado->ip=$ip;
    //
    //
    $certificado->qr='qr';
    //Fechas de Certificado
    if($request->level=='Basic Level'){
      if($request->tipo_certificado_id!=8){
      //NORMAL
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      $certificado->fecha_expiracion=$fecha_expiracion;
      }
      else{
      //NORMAL
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      $certificado->fecha_expiracion=$fecha_expiracion;
      }
      
      //Fecha Formateada - Emisión
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fec_emi="$mes7 $dia7, $ano7";
      //Fecha Formateada - Expiración
      $mese=date('F',strtotime($fecha_expiracion));
      $diae=date('d',strtotime($fecha_expiracion));
      $anoe=date('Y',strtotime($fecha_expiracion));
      $fec_exp="$mese $diae, $anoe";
      //Ingresar Fecha para certificado
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
    }
    elseif($request->level=='Standard Level'){
        if($request->tipo_certificado_id!=8){
      //NORMAL
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      $certificado->fecha_expiracion=$fecha_expiracion;
      }
      else{
      //NORMAL
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      $certificado->fecha_expiracion=$fecha_expiracion;
      }
      
      //Fecha Formateada - Emisión
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fec_emi="$mes7 $dia7, $ano7";
      //Fecha Formateada - Expiración
      $mese=date('F',strtotime($fecha_expiracion));
      $diae=date('d',strtotime($fecha_expiracion));
      $anoe=date('Y',strtotime($fecha_expiracion));
      $fec_exp="$mese $diae, $anoe";
      //Ingresar Fecha para certificado
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
    }
    elseif($request->level=='Intermediate Level' || $request->level==''){
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      //Fecha Formateada - Emisión
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fec_emi="$mes7 $dia7, $ano7";
      //Fecha Formateada - Expiración
      $mese=date('F',strtotime($fecha_expiracion));
      $diae=date('d',strtotime($fecha_expiracion));
      $anoe=date('Y',strtotime($fecha_expiracion));
      $fec_exp="$mese $diae, $anoe";
      
      if($request->tipo_certificado_id<7){
        $fecha_re = $request->fecha_emision7;
        $fec_reevaluacion = strtotime ('+1 year -1 day', strtotime($fecha_re));
        $fec_reevaluacion = date('Y-m-d',$fec_reevaluacion);
        $certificado->fecha_revalidacion=$fec_reevaluacion;
        //Fecha Formateada - Reevaluación
        $mesr=date('F',strtotime($fec_reevaluacion));
        $diar=date('d',strtotime($fec_reevaluacion));
        $anor=date('Y',strtotime($fec_reevaluacion));
        $fec_rev="$mesr $diar, $anor";
        $certificado->fecha_expiracion=$fecha_expiracion;
        $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;REVALIDATE: $fec_rev<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_exp";
      }
      else{
      $certificado->fecha_expiracion=$fecha_expiracion;
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
      }
    }
    elseif($request->level=='Level 1'){
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      //$certificado->fecha_emision7=$fecha_expiracion;
      //Fecha Formateada - Emisión
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fec_emi="$mes7 $dia7, $ano7";
      
      //Fecha Formateada - Expiración
      $mese=date('F',strtotime($fecha_expiracion));
      $diae=date('d',strtotime($fecha_expiracion));
      $anoe=date('Y',strtotime($fecha_expiracion));
      $fec_exp="$mese $diae, $anoe";
      $certificado->fecha_expiracion=$fecha_expiracion;
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
    }
    elseif($request->level=='Level I'){
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      //$certificado->fecha_emision7=$fecha_expiracion;
      //Fecha Formateada - Emisión
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fec_emi="$mes7 $dia7, $ano7";
      //Fecha Formateada - Expiración
      $mese=date('F',strtotime($fecha_expiracion));
      $diae=date('d',strtotime($fecha_expiracion));
      $anoe=date('Y',strtotime($fecha_expiracion));
      $fec_exp="$mese $diae, $anoe";
      $certificado->fecha_expiracion=$fecha_expiracion;
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
    }
    else{
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      //$certificado->fecha_emision7=$fecha_expiracion;
      $certificado->fecha_expiracion=$fecha_expiracion;
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
    }
    
    // Designación Certificado
    $certificado->idtipo_certificado=$request->tipo_certificado_id;
    $tipo = Tipo_Certificado::findOrFail($request->tipo_certificado_id);
    if($request->tipo_certificado_id == 8){
      $request->level = "";
    }
    $designacion = Designacion::findOrFail($request->iddesignacion);
        $certificado->designacion=$designacion->designacion_ingles;
        $certificado->iddesignacion=$request->iddesignacion;
    $certificado->level=$request->level;
    $certificado->horas=$request->horas;
    $certificado->normativa=$request->normativa;
    $certificado->cond_equipo=$request->cond_equipo;
    
    $certificado->dias=$request->dias;
    //fechas
    if($request->dias==1){
      $certificado->fecha_emision7=$request->fecha_emision7;
      //fecha fin
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7a=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $datofecha = "$mes7 $dia7a<sup>$indice7a</sup>, $ano7";
    }
    elseif($request->dias==2){
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      if($mes1==$mes7){
        $datofecha = "$mes7 $dia1<sup>$indice1</sup> & $dia7<sup>$indice7a</sup>, $ano7";
      }
      else{
        if($ano1==$ano7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        else{
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
      }

    }
    elseif($request->dias==3){
      
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      //fecha 2
      $certificado->fecha_emision2=$request->fecha_emision2;
      $mes2=date('F',strtotime($request->fecha_emision2));
      $dia2=date('d',strtotime($request->fecha_emision2));
      $indice2=date('S',strtotime($request->fecha_emision2));
      $ano2=date('Y',strtotime($request->fecha_emision2));
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      if($ano1==$ano2 && $ano2==$ano7){
        if($mes1==$mes7 && $mes2==$mes1){
          $datofecha = "$mes7 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1==$mes2 && $mes2!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes2==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        else{
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";  
        }
      }
      elseif($ano1==$ano2 && $ano2!=$ano7){
        if($mes1==$mes2){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $ano1 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $ano1 & $dia7<sup>$indice7a</sup>, $ano7";
        }
      }
      elseif($ano1!=$ano2 && $ano2==$ano7){
        if($mes2==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes2!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup> <br/> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
      }
      
    }
    elseif($request->dias==4){
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      //fecha 2
      $certificado->fecha_emision2=$request->fecha_emision2;
      $mes2=date('F',strtotime($request->fecha_emision2));
      $dia2=date('d',strtotime($request->fecha_emision2));
      $indice2=date('S',strtotime($request->fecha_emision2));
      $ano2=date('Y',strtotime($request->fecha_emision2));
      //fecha 3
      $certificado->fecha_emision3=$request->fecha_emision3;
      $mes3=date('F',strtotime($request->fecha_emision3));
      $dia3=date('d',strtotime($request->fecha_emision3));
      $indice3=date('S',strtotime($request->fecha_emision3));
      $ano3=date('Y',strtotime($request->fecha_emision3));
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));

      if($ano1==$ano7){
        if($mes1==$mes2 && $mes2==$mes3 && $mes3==$mes7){
          $datofecha = "$mes7 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1==$mes3 && $mes3!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1==$mes2 && $mes2!=$mes3 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $mes7 $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes2==$mes3 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes7 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
      }
      elseif($ano1==$ano2 && $ano2==$ano3 && $ano3!=$ano7){
        if($mes1==$mes2 && $mes2==$mes3){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }

        elseif($mes1==$mes2 && $mes2!=$mes3){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes2==$mes3){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes2!=$mes3){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
      }
      elseif($ano1==$ano2 && $ano2!=$ano3 && $ano3==$ano7){
        if($mes1==$mes2 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $ano2, $mes7  $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }

        elseif($mes1==$mes2 && $mes3!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $ano2, $mes3 $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $ano2, $mes3 $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes3!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $ano2, $mes3 $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }}
      elseif($ano1!=$ano2 && $ano2==$ano3 && $ano3==$ano7){
        if($mes2==$mes3 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes2!=$mes3 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes2==$mes3 && $mes3!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes2!=$mes3 && $mes3!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
      }  
      }
    elseif($request->dias==5){
      
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      $fecha1 ="$mes1 $dia1<sup>$indice1</sup>, $ano1";
      //fecha 2
      $certificado->fecha_emision2=$request->fecha_emision2;
      $mes2=date('F',strtotime($request->fecha_emision2));
      $dia2=date('d',strtotime($request->fecha_emision2));
      $indice2=date('S',strtotime($request->fecha_emision2));
      $ano2=date('Y',strtotime($request->fecha_emision2));
      $fecha2 ="$mes2 $dia2<sup>$indice2</sup>, $ano2";
      //fecha 3
      $certificado->fecha_emision3=$request->fecha_emision3;
      $mes3=date('F',strtotime($request->fecha_emision3));
      $dia3=date('d',strtotime($request->fecha_emision3));
      $indice3=date('S',strtotime($request->fecha_emision3));
      $ano3=date('Y',strtotime($request->fecha_emision3));
      $fecha3 ="$mes3 $dia3<sup>$indice3</sup>, $ano3";
      //fecha 4
      $certificado->fecha_emision4=$request->fecha_emision4;
      $mes4=date('F',strtotime($request->fecha_emision4));
      $dia4=date('d',strtotime($request->fecha_emision4));
      $indice4=date('S',strtotime($request->fecha_emision4));
      $ano4=date('Y',strtotime($request->fecha_emision4));
      $fecha4 ="$mes4 $dia4<sup>$indice4</sup>, $ano4";
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fecha7 ="$mes7 $dia7<sup>$indice7</sup>, $ano7";

      $datofecha="$fecha1 , $fecha2, $fecha3, $fecha4 & $fecha7";
    }
    elseif($request->dias==6){
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      $fecha1 ="$mes1 $dia1<sup>$indice1</sup>, $ano1";
      //fecha 2
      $certificado->fecha_emision2=$request->fecha_emision2;
      $mes2=date('F',strtotime($request->fecha_emision2));
      $dia2=date('d',strtotime($request->fecha_emision2));
      $indice2=date('S',strtotime($request->fecha_emision2));
      $ano2=date('Y',strtotime($request->fecha_emision2));
      $fecha2 ="$mes2 $dia2<sup>$indice2</sup>, $ano2";
      //fecha 3
      $certificado->fecha_emision3=$request->fecha_emision3;
      $mes3=date('F',strtotime($request->fecha_emision3));
      $dia3=date('d',strtotime($request->fecha_emision3));
      $indice3=date('S',strtotime($request->fecha_emision3));
      $ano3=date('Y',strtotime($request->fecha_emision3));
      $fecha3 ="$mes3 $dia3<sup>$indice3</sup>, $ano3";
      //fecha 4
      $certificado->fecha_emision4=$request->fecha_emision4;
      $mes4=date('F',strtotime($request->fecha_emision4));
      $dia4=date('d',strtotime($request->fecha_emision4));
      $indice4=date('S',strtotime($request->fecha_emision4));
      $ano4=date('Y',strtotime($request->fecha_emision4));
      $fecha4 ="$mes4 $dia4<sup>$indice4</sup>, $ano4";
      //fecha 5
      $certificado->fecha_emision5=$request->fecha_emision5;
      $mes5=date('F',strtotime($request->fecha_emision5));
      $dia5=date('d',strtotime($request->fecha_emision5));
      $indice5=date('S',strtotime($request->fecha_emision5));
      $ano5=date('Y',strtotime($request->fecha_emision5));
      $fecha5 ="$mes5 $dia5<sup>$indice5</sup>, $ano5";
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fecha7 ="$mes7 $dia7<sup>$indice7</sup>, $ano7";
      $datofecha="$fecha1 , $fecha2, $fecha3, $fecha4, $fecha5 & $fecha7";
    }
    elseif($request->dias==7){
      $certificado->fecha_emision=$request->fecha_emision;
      $certificado->fecha_emision2=$request->fecha_emision2;
      $certificado->fecha_emision3=$request->fecha_emision3;
      $certificado->fecha_emision4=$request->fecha_emision4;
      $certificado->fecha_emision5=$request->fecha_emision5;
      $certificado->fecha_emision6=$request->fecha_emision6;
      $certificado->fecha_emision7=$request->fecha_emision7;
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      $fecha1 ="$mes1 $dia1<sup>$indice1</sup>, $ano1";
      //fecha 2
      $certificado->fecha_emision2=$request->fecha_emision2;
      $mes2=date('F',strtotime($request->fecha_emision2));
      $dia2=date('d',strtotime($request->fecha_emision2));
      $indice2=date('S',strtotime($request->fecha_emision2));
      $ano2=date('Y',strtotime($request->fecha_emision2));
      $fecha2 ="$mes2 $dia2<sup>$indice2</sup>, $ano2";
      //fecha 3
      $certificado->fecha_emision3=$request->fecha_emision3;
      $mes3=date('F',strtotime($request->fecha_emision3));
      $dia3=date('d',strtotime($request->fecha_emision3));
      $indice3=date('S',strtotime($request->fecha_emision3));
      $ano3=date('Y',strtotime($request->fecha_emision3));
      $fecha3 ="$mes3 $dia3<sup>$indice3</sup>, $ano3";
      //fecha 4
      $certificado->fecha_emision4=$request->fecha_emision4;
      $mes4=date('F',strtotime($request->fecha_emision4));
      $dia4=date('d',strtotime($request->fecha_emision4));
      $indice4=date('S',strtotime($request->fecha_emision4));
      $ano4=date('Y',strtotime($request->fecha_emision4));
      $fecha4 ="$mes4 $dia4<sup>$indice4</sup>, $ano4";
      //fecha 5
      $certificado->fecha_emision5=$request->fecha_emision5;
      $mes5=date('F',strtotime($request->fecha_emision5));
      $dia5=date('d',strtotime($request->fecha_emision5));
      $indice5=date('S',strtotime($request->fecha_emision5));
      $ano5=date('Y',strtotime($request->fecha_emision5));
      $fecha5 ="$mes5 $dia5<sup>$indice5</sup>, $ano5";
      //fecha 6
      $certificado->fecha_emision6=$request->fecha_emision6;
      $mes6=date('F',strtotime($request->fecha_emision6));
      $dia6=date('d',strtotime($request->fecha_emision6));
      $indice6=date('S',strtotime($request->fecha_emision6));
      $ano6=date('Y',strtotime($request->fecha_emision6));
      $fecha6 ="$mes6 $dia6<sup>$indice6</sup>, $ano6";
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fecha7 ="$mes7 $dia7<sup>$indice7</sup>, $ano7";

      $datofecha="$fecha1 , $fecha2, $fecha3, $fecha4, $fecha5, $fecha6 & $fecha7";
    }
    else{
      $certificado->fecha_emision7='2020-09-11';
      $datofecha = '';
    }

  
    
    if($request->tipo_certificado_id == 12){
      $designacion_certificado = $designacion->designacion_ingles;
    }
    else{
      $designacion_certificado = "$designacion->designacion_ingles $tipo->nombre";
    }
    if($request->cond_equipo==1){ 
      $certificado->equipo=$request->equipo;
      $certificado->description="<b style=\"font-size:12pt;\">$designacion_certificado:
<br/> $request->equipo 
<br/>$request->level</b>
<br/> Under current aplicable code(s): $request->normativa 
<br/><font style=\"font-size:12pt;\">Training and examinations on $datofecha
<br/>($request->horas hours in total)</font>";
    }
    elseif($request->cond_equipo==0){ 
      
      $certificado->description="<b style=\"font-size:12pt;\">$designacion_certificado
<br/>$request->level</b>
<br/> Under current aplicable code(s): $request->normativa 
<br/><font style=\"font-size:12pt;\">Training and examinations on $datofecha
<br/>($request->horas hours in total)</font>";
    }
    
    elseif($request->cond_equipo==2){ 
      $certificado->equipo=$request->equipo;
      $certificado->description="<b style=\"font-size:12pt;\">$designacion_certificado:
<br/> $request->equipo 
<br/>$request->level</b>
<br/><font style=\"font-size:12pt;\">Training and examinations on $datofecha
<br/> Under recommendations: $request->normativa 
<br/>($request->horas hours in total)</font>";
    }
    else{
      $certificado->description="Datos Incorrectos";
    }
    
    
    $certificado->condicion='1';
    $certificado->toneladas=$request->toneladas;
    $certificado->save();

    //Carné
    $carne = Carne::findOrFail($request->idcarne);
    $carne->idusuario  = Auth::user()->id;
    $carne->iddesignacion=$designacion->id;
    $carne->idcertificado=$certificado->id;
    $carne->foto=$persona->imagen;
    $carne->designacion_espanol=$designacion->designacion_espanol;
    if($request->cond_equipo==2){
    $carne->equipo_espanol=$request->equipoes;
    $equipocarne=$request->equipoes;
    }
    else {
      $carne->equipo_espanol=$request->equipo;
      $equipocarne=$request->equipo;
    }
    $carne->normativa_espanol=$request->normativaes;
    $fechaEmisionC=date("d/m/Y", strtotime($request->fecha_emision7));
    
    $fechaVenceC=date("d/m/Y", strtotime($fecha_expiracion));
    if($request->level!='Intermediate Level'){
      //if($request->tipo_certificado_id==5 || $request->tipo_certificado_id==6 || $request->tipo_certificado_id==7 || $request->tipo_certificado_id==8){
        
        $carne->reevaluacion=0;
      //}
      

      $carne->fechacarne="<font style=\"font-size:8pt;\">
EMITIDO: $fechaEmisionC<br>
VENCE: $fechaVenceC</font>";

    }
    else {
      if($request->tipo_certificado_id==5 || $request->tipo_certificado_id==6){
        $carne->reevaluacion=1;
        $fechaRevalidC=date("d/m/Y", strtotime($fec_reevaluacion));
      }
      else {
        $carne->reevaluacion=0;
      }
      $carne->fechacarne="<font style=\"font-size:8pt;\">
EMITIDO: $fechaEmisionC<br>
REVALIDAR: $fechaRevalidC</font>";
    }
    $carne->nombrescarne="<font style=\"font-size:8pt;\">$persona->nombre $persona->apellido</font>";
    $carne->empresacarne="<font style=\"font-size:8pt;\">$request->empresa</font>";
    $desig='';
    switch($request->tipo_certificado_id){
      case 5: $desig='Operador';
      
          break;
      case 6: $desig='Aparejador';
          break;
      case 7: $desig='Supervisor';

          break;
      case 8: $desig='INSPECTOR';
          break;
    }
    $designacion = Designacion::findOrFail($request->iddesignacion);
    if($request->level=="Basic Level"){ $nivelcarne='Nivel Básico'; $carne->estado=0;}
    elseif($request->level=="Intermediate Level"){ 
      $nivelcarne='Nivel Intermedio';
      if($request->tipo_certificado_id==5 || $request->tipo_certificado_id==6){
        $carne->estado=1;}
      else{
        $carne->estado=0;
      }
           }
           elseif($request->level=="Level 1"){ $nivelcarne='Level 1';$carne->estado=0;}
           elseif($request->level=="Level I"){ $nivelcarne='Level 1';$carne->estado=0;}
           elseif($request->level=="Standard Level"){ $nivelcarne='Nivel Estándar';$carne->estado=0;}
           else{
             $nivelcarne='';
           }
               if($request->cond_equipo==0){
                 if($request->tipo_certificado_id==8 || $request->tipo_certificado_id==7){
                   $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$designacion->designacion_espanol $desig
             </font>";}
                 elseif ($request->tipo_certificado_id==12) {
                   $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$designacion->designacion_espanol 
             </font><br>
             <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";
                 }
                     else{
                    $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$desig de $designacion->designacion_espanol 
             </font><br><br>
             <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";
                     }
               }
               else{
               if($request->tipo_certificado_id==12) {
                 $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$designacion->designacion_espanol </font>
                 <br>
             <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";
               }
               else{
               $carne->designacioncarne="<font style=\"font-size:8pt;\"><br/>$desig de $designacion->designacion_espanol: 
       <br/>$equipocarne</font><br><br>
       <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";}}
    
    
    $carne->save();

    
    }
    public function update1(Request $request)
    {  //dd($request->all());
      //Actualizar Firma
     
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
        // Si se utiliza un proxy, esto nos daria la IP del proxy
        // y no la IP real del usuario.
        $ip = $_SERVER['REMOTE_ADDR'];
      }
    if(!$request->ajax()) return redirect('/');
    $certificado = Certificado::findOrFail($request->id);
    $edicion=Edicion::find($request->id_edicion);
    if($edicion->condicion==7){
      $certificado->idfirma=$request->firma_id;
      //dd($certificado->idfirma);
      $certificado->update();
    }
    else{
    $certificado->idpersona=$request->persona_id;
    
    $certificado->idfirma=$request->firma_id;
    //
    $persona = Persona::findOrFail($request->persona_id);
    $certificado->persona=$persona->nombre.' '.$persona->apellido;
    //
    $certificado->empresa=$request->empresa;
    $certificado->cabecera="<h1 class='contenido' style=\"font-size:19pt;\">$persona->nombre $persona->apellido<br><font style=\"font-size:18pt;\">$request->empresa</font></h1>";
    $certificado->ip=$ip;
    //
    //
    $qrcode = new Generator;
    $nombre=time().$persona->apellido.'.svg';
        $certificado->qr=$nombre;
        $qr='https://certificado.cicbla.com/verificar?dni='.$persona->dni.'&certificado='.$certificado->certificado;
        $qrcode->format('svg')->size(120)->generate($qr,'../public/qrcodes/'.$nombre);
    //Fechas de Certificado
    if($request->level=='Basic Level'){
      if($request->tipo_certificado_id!=8){
      //NORMAL
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      $certificado->fecha_expiracion=$fecha_expiracion;
      }
      else{
      //NORMAL
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      $certificado->fecha_expiracion=$fecha_expiracion;
      }
      
      //Fecha Formateada - Emisión
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fec_emi="$mes7 $dia7, $ano7";
      //Fecha Formateada - Expiración
      $mese=date('F',strtotime($fecha_expiracion));
      $diae=date('d',strtotime($fecha_expiracion));
      $anoe=date('Y',strtotime($fecha_expiracion));
      $fec_exp="$mese $diae, $anoe";
      //Ingresar Fecha para certificado
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
    }
    elseif($request->level=='Standard Level'){
      if($request->tipo_certificado_id!=8){
      //NORMAL
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      $certificado->fecha_expiracion=$fecha_expiracion;
      }
      else{
      //NORMAL
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      $certificado->fecha_expiracion=$fecha_expiracion;
      }
      
      //Fecha Formateada - Emisión
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fec_emi="$mes7 $dia7, $ano7";
      //Fecha Formateada - Expiración
      $mese=date('F',strtotime($fecha_expiracion));
      $diae=date('d',strtotime($fecha_expiracion));
      $anoe=date('Y',strtotime($fecha_expiracion));
      $fec_exp="$mese $diae, $anoe";
      //Ingresar Fecha para certificado
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
    }
    elseif($request->level=='Intermediate Level' || $request->level==''){
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      //Fecha Formateada - Emisión
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fec_emi="$mes7 $dia7, $ano7";
      //Fecha Formateada - Expiración
      $mese=date('F',strtotime($fecha_expiracion));
      $diae=date('d',strtotime($fecha_expiracion));
      $anoe=date('Y',strtotime($fecha_expiracion));
      $fec_exp="$mese $diae, $anoe";
      
      if($request->tipo_certificado_id<7){
        $fecha_re = $request->fecha_emision7;
        $fec_reevaluacion = strtotime ('+1 year -1 day', strtotime($fecha_re));
        $fec_reevaluacion = date('Y-m-d',$fec_reevaluacion);
        $certificado->fecha_revalidacion=$fec_reevaluacion;
        //Fecha Formateada - Reevaluación
        $mesr=date('F',strtotime($fec_reevaluacion));
        $diar=date('d',strtotime($fec_reevaluacion));
        $anor=date('Y',strtotime($fec_reevaluacion));
        $fec_rev="$mesr $diar, $anor";
        $certificado->fecha_expiracion=$fecha_expiracion;
        $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;REVALIDATE: $fec_rev<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_exp";
      }
      else{
      $certificado->fecha_expiracion=$fecha_expiracion;
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
      }
    }
    elseif($request->level=='Level 1'){
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      //$certificado->fecha_emision7=$fecha_expiracion;
      //Fecha Formateada - Emisión
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fec_emi="$mes7 $dia7, $ano7";
      
      //Fecha Formateada - Expiración
      $mese=date('F',strtotime($fecha_expiracion));
      $diae=date('d',strtotime($fecha_expiracion));
      $anoe=date('Y',strtotime($fecha_expiracion));
      $fec_exp="$mese $diae, $anoe";
      $certificado->fecha_expiracion=$fecha_expiracion;
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
    }
    elseif($request->level=='Level I'){
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+2 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      //$certificado->fecha_emision7=$fecha_expiracion;
      //Fecha Formateada - Emisión
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fec_emi="$mes7 $dia7, $ano7";
      //Fecha Formateada - Expiración
      $mese=date('F',strtotime($fecha_expiracion));
      $diae=date('d',strtotime($fecha_expiracion));
      $anoe=date('Y',strtotime($fecha_expiracion));
      $fec_exp="$mese $diae, $anoe";
      $certificado->fecha_expiracion=$fecha_expiracion;
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
    }
    else{
      $fecha_antes = $request->fecha_emision7;
      $fecha_expiracion = strtotime ('+1 year -1 day', strtotime($fecha_antes));
      $fecha_expiracion = date('Y-m-d',$fecha_expiracion);
      //$certificado->fecha_emision7=$fecha_expiracion;
      $certificado->fecha_expiracion=$fecha_expiracion;
      $certificado->fecha="&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fec_emi<br/>
&nbsp;&nbsp;&nbsp;&nbsp;EXPIRES:&nbsp;$fec_exp";
    }
    
    // Designación Certificado
    $certificado->idtipo_certificado=$request->tipo_certificado_id;
    $tipo = Tipo_Certificado::findOrFail($request->tipo_certificado_id);
    if($request->tipo_certificado_id == 8){
      $request->level = "";
    }
    $designacion = Designacion::findOrFail($request->iddesignacion);
        $certificado->designacion=$designacion->designacion_ingles;
        $certificado->iddesignacion=$request->iddesignacion;
    $certificado->level=$request->level;
    $certificado->horas=$request->horas;
    $certificado->normativa=$request->normativa;
    $certificado->cond_equipo=$request->cond_equipo;
    
    $certificado->dias=$request->dias;
    //fechas
    if($request->dias==1){
      $certificado->fecha_emision7=$request->fecha_emision7;
      //fecha fin
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7a=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $datofecha = "$mes7 $dia7a<sup>$indice7a</sup>, $ano7";
    }
    elseif($request->dias==2){
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      if($mes1==$mes7){
        $datofecha = "$mes7 $dia1<sup>$indice1</sup> & $dia7<sup>$indice7a</sup>, $ano7";
      }
      else{
        if($ano1==$ano7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        else{
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
      }

    }
    elseif($request->dias==3){
      
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      //fecha 2
      $certificado->fecha_emision2=$request->fecha_emision2;
      $mes2=date('F',strtotime($request->fecha_emision2));
      $dia2=date('d',strtotime($request->fecha_emision2));
      $indice2=date('S',strtotime($request->fecha_emision2));
      $ano2=date('Y',strtotime($request->fecha_emision2));
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      if($ano1==$ano2 && $ano2==$ano7){
        if($mes1==$mes7 && $mes2==$mes1){
          $datofecha = "$mes7 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1==$mes2 && $mes2!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes2==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
      }
      elseif($ano1==$ano2 && $ano2!=$ano7){
        if($mes1==$mes2){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $ano1 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $ano1 & $dia7<sup>$indice7a</sup>, $ano7";
        }
      }
      elseif($ano1!=$ano2 && $ano2==$ano7){
        if($mes2==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes2!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup> <br/> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
      }
      
    }
    elseif($request->dias==4){
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      //fecha 2
      $certificado->fecha_emision2=$request->fecha_emision2;
      $mes2=date('F',strtotime($request->fecha_emision2));
      $dia2=date('d',strtotime($request->fecha_emision2));
      $indice2=date('S',strtotime($request->fecha_emision2));
      $ano2=date('Y',strtotime($request->fecha_emision2));
      //fecha 3
      $certificado->fecha_emision3=$request->fecha_emision3;
      $mes3=date('F',strtotime($request->fecha_emision3));
      $dia3=date('d',strtotime($request->fecha_emision3));
      $indice3=date('S',strtotime($request->fecha_emision3));
      $ano3=date('Y',strtotime($request->fecha_emision3));
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));

      if($ano1==$ano7){
        if($mes1==$mes2 && $mes2==$mes3 && $mes3==$mes7){
          $datofecha = "$mes7 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1==$mes3 && $mes3!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1==$mes2 && $mes2!=$mes3 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $mes7 $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes2==$mes3 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes7 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
      }
      elseif($ano1==$ano2 && $ano2==$ano3 && $ano3!=$ano7){
        if($mes1==$mes2 && $mes2==$mes3){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }

        elseif($mes1==$mes2 && $mes2!=$mes3){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes2==$mes3){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes2!=$mes3){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup>, $ano3 & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
      }
      elseif($ano1==$ano2 && $ano2!=$ano3 && $ano3==$ano7){
        if($mes1==$mes2 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $ano2, $mes7  $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }

        elseif($mes1==$mes2 && $mes3!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $dia2<sup>$indice2</sup>, $ano2, $mes3 $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $ano2, $mes3 $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes1!=$mes2 && $mes3!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $mes2 $dia2<sup>$indice2</sup>, $ano2, $mes3 $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }}
      elseif($ano1!=$ano2 && $ano2==$ano3 && $ano3==$ano7){
        if($mes2==$mes3 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes2!=$mes3 && $mes3==$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup> & $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes2==$mes3 && $mes3!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
        elseif($mes2!=$mes3 && $mes3!=$mes7){
          $datofecha = "$mes1 $dia1<sup>$indice1</sup>, $ano1, $mes2 $dia2<sup>$indice2</sup>, $mes3 $dia3<sup>$indice3</sup> & $mes7 $dia7<sup>$indice7a</sup>, $ano7";
        }
      }  
      }
    elseif($request->dias==5){
      
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      $fecha1 ="$mes1 $dia1<sup>$indice1</sup>, $ano1";
      //fecha 2
      $certificado->fecha_emision2=$request->fecha_emision2;
      $mes2=date('F',strtotime($request->fecha_emision2));
      $dia2=date('d',strtotime($request->fecha_emision2));
      $indice2=date('S',strtotime($request->fecha_emision2));
      $ano2=date('Y',strtotime($request->fecha_emision2));
      $fecha2 ="$mes2 $dia2<sup>$indice2</sup>, $ano2";
      //fecha 3
      $certificado->fecha_emision3=$request->fecha_emision3;
      $mes3=date('F',strtotime($request->fecha_emision3));
      $dia3=date('d',strtotime($request->fecha_emision3));
      $indice3=date('S',strtotime($request->fecha_emision3));
      $ano3=date('Y',strtotime($request->fecha_emision3));
      $fecha3 ="$mes3 $dia3<sup>$indice3</sup>, $ano3";
      //fecha 4
      $certificado->fecha_emision4=$request->fecha_emision4;
      $mes4=date('F',strtotime($request->fecha_emision4));
      $dia4=date('d',strtotime($request->fecha_emision4));
      $indice4=date('S',strtotime($request->fecha_emision4));
      $ano4=date('Y',strtotime($request->fecha_emision4));
      $fecha4 ="$mes4 $dia4<sup>$indice4</sup>, $ano4";
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fecha7 ="$mes7 $dia7<sup>$indice7</sup>, $ano7";

      $datofecha="$fecha1 , $fecha2, $fecha3, $fecha4 & $fecha7";
    }
    elseif($request->dias==6){
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      $fecha1 ="$mes1 $dia1<sup>$indice1</sup>, $ano1";
      //fecha 2
      $certificado->fecha_emision2=$request->fecha_emision2;
      $mes2=date('F',strtotime($request->fecha_emision2));
      $dia2=date('d',strtotime($request->fecha_emision2));
      $indice2=date('S',strtotime($request->fecha_emision2));
      $ano2=date('Y',strtotime($request->fecha_emision2));
      $fecha2 ="$mes2 $dia2<sup>$indice2</sup>, $ano2";
      //fecha 3
      $certificado->fecha_emision3=$request->fecha_emision3;
      $mes3=date('F',strtotime($request->fecha_emision3));
      $dia3=date('d',strtotime($request->fecha_emision3));
      $indice3=date('S',strtotime($request->fecha_emision3));
      $ano3=date('Y',strtotime($request->fecha_emision3));
      $fecha3 ="$mes3 $dia3<sup>$indice3</sup>, $ano3";
      //fecha 4
      $certificado->fecha_emision4=$request->fecha_emision4;
      $mes4=date('F',strtotime($request->fecha_emision4));
      $dia4=date('d',strtotime($request->fecha_emision4));
      $indice4=date('S',strtotime($request->fecha_emision4));
      $ano4=date('Y',strtotime($request->fecha_emision4));
      $fecha4 ="$mes4 $dia4<sup>$indice4</sup>, $ano4";
      //fecha 5
      $certificado->fecha_emision5=$request->fecha_emision5;
      $mes5=date('F',strtotime($request->fecha_emision5));
      $dia5=date('d',strtotime($request->fecha_emision5));
      $indice5=date('S',strtotime($request->fecha_emision5));
      $ano5=date('Y',strtotime($request->fecha_emision5));
      $fecha5 ="$mes5 $dia5<sup>$indice5</sup>, $ano5";
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fecha7 ="$mes7 $dia7<sup>$indice7</sup>, $ano7";
      $datofecha="$fecha1 , $fecha2, $fecha3, $fecha4, $fecha5 & $fecha7";
    }
    elseif($request->dias==7){
      $certificado->fecha_emision=$request->fecha_emision;
      $certificado->fecha_emision2=$request->fecha_emision2;
      $certificado->fecha_emision3=$request->fecha_emision3;
      $certificado->fecha_emision4=$request->fecha_emision4;
      $certificado->fecha_emision5=$request->fecha_emision5;
      $certificado->fecha_emision6=$request->fecha_emision6;
      $certificado->fecha_emision7=$request->fecha_emision7;
      //fecha 1
      $certificado->fecha_emision=$request->fecha_emision;
      $mes1=date('F',strtotime($request->fecha_emision));
      $dia1=date('d',strtotime($request->fecha_emision));
      $indice1=date('S',strtotime($request->fecha_emision));
      $ano1=date('Y',strtotime($request->fecha_emision));
      $fecha1 ="$mes1 $dia1<sup>$indice1</sup>, $ano1";
      //fecha 2
      $certificado->fecha_emision2=$request->fecha_emision2;
      $mes2=date('F',strtotime($request->fecha_emision2));
      $dia2=date('d',strtotime($request->fecha_emision2));
      $indice2=date('S',strtotime($request->fecha_emision2));
      $ano2=date('Y',strtotime($request->fecha_emision2));
      $fecha2 ="$mes2 $dia2<sup>$indice2</sup>, $ano2";
      //fecha 3
      $certificado->fecha_emision3=$request->fecha_emision3;
      $mes3=date('F',strtotime($request->fecha_emision3));
      $dia3=date('d',strtotime($request->fecha_emision3));
      $indice3=date('S',strtotime($request->fecha_emision3));
      $ano3=date('Y',strtotime($request->fecha_emision3));
      $fecha3 ="$mes3 $dia3<sup>$indice3</sup>, $ano3";
      //fecha 4
      $certificado->fecha_emision4=$request->fecha_emision4;
      $mes4=date('F',strtotime($request->fecha_emision4));
      $dia4=date('d',strtotime($request->fecha_emision4));
      $indice4=date('S',strtotime($request->fecha_emision4));
      $ano4=date('Y',strtotime($request->fecha_emision4));
      $fecha4 ="$mes4 $dia4<sup>$indice4</sup>, $ano4";
      //fecha 5
      $certificado->fecha_emision5=$request->fecha_emision5;
      $mes5=date('F',strtotime($request->fecha_emision5));
      $dia5=date('d',strtotime($request->fecha_emision5));
      $indice5=date('S',strtotime($request->fecha_emision5));
      $ano5=date('Y',strtotime($request->fecha_emision5));
      $fecha5 ="$mes5 $dia5<sup>$indice5</sup>, $ano5";
      //fecha 6
      $certificado->fecha_emision6=$request->fecha_emision6;
      $mes6=date('F',strtotime($request->fecha_emision6));
      $dia6=date('d',strtotime($request->fecha_emision6));
      $indice6=date('S',strtotime($request->fecha_emision6));
      $ano6=date('Y',strtotime($request->fecha_emision6));
      $fecha6 ="$mes6 $dia6<sup>$indice6</sup>, $ano6";
      //fecha fin
      $certificado->fecha_emision7=$request->fecha_emision7;
      $mes7=date('F',strtotime($request->fecha_emision7));
      $dia7=date('d',strtotime($request->fecha_emision7));
      $indice7a=date('S',strtotime($request->fecha_emision7));
      $ano7=date('Y',strtotime($request->fecha_emision7));
      $fecha7 ="$mes7 $dia7<sup>$indice7</sup>, $ano7";

      $datofecha="$fecha1 , $fecha2, $fecha3, $fecha4, $fecha5, $fecha6 & $fecha7";
    }
    else{
      $certificado->fecha_emision7='2020-09-11';
      $datofecha = '';
    }

  
    
    if($request->tipo_certificado_id == 12){
      $designacion_certificado = $designacion->designacion_ingles;
    }
    else{
      $designacion_certificado = "$designacion->designacion_ingles $tipo->nombre";
    }
    if($request->cond_equipo==1){ 
      $certificado->equipo=$request->equipo;
      $certificado->description="<b style=\"font-size:12pt;\">$designacion_certificado:
<br/> $request->equipo 
<br/>$request->level</b>
<br/> Under current aplicable code(s): $request->normativa 
<br/><font style=\"font-size:12pt;\">Training and examinations on $datofecha
<br/>($request->horas hours in total)</font>";
    }
    elseif($request->cond_equipo==0){ 
      
      $certificado->description="<b style=\"font-size:12pt;\">$designacion_certificado
<br/>$request->level</b>
<br/> Under current aplicable code(s): $request->normativa 
<br/><font style=\"font-size:12pt;\">Training and examinations on $datofecha
<br/>($request->horas hours in total)</font>";
    }
    
    elseif($request->cond_equipo==2){ 
      $certificado->equipo=$request->equipo;
      $certificado->description="<b style=\"font-size:12pt;\">$designacion_certificado:
<br/> $request->equipo 
<br/>$request->level</b>
<br/><font style=\"font-size:12pt;\">Training and examinations on $datofecha
<br/> Under recommendations: $request->normativa 
<br/>($request->horas hours in total)</font>";
    }
    else{
      $certificado->description="Datos Incorrectos";
    }
    
    
    $certificado->condicion='2';
    $certificado->qr;
    $certificado->toneladas=$request->toneladas;
    $certificado->save();

    //Carné
    $carne = Carne::findOrFail($request->idcarne);
    $carne->idusuario  = Auth::user()->id;
    $carne->iddesignacion=$designacion->id;
    $carne->idcertificado=$certificado->id;
    $carne->foto=$persona->imagen;
    $carne->designacion_espanol=$designacion->designacion_espanol;
    if($request->cond_equipo==2){
    $carne->equipo_espanol=$request->equipoes;
    $equipocarne=$request->equipoes;
    }
    else {
      $carne->equipo_espanol=$request->equipo;
      $equipocarne=$request->equipo;
    }
    $carne->normativa_espanol=$request->normativaes;
    $fechaEmisionC=date("d/m/Y", strtotime($request->fecha_emision7));
    
    $fechaVenceC=date("d/m/Y", strtotime($fecha_expiracion));
    if($request->level!='Intermediate Level'){
      if($request->tipo_certificado_id==5 || $request->tipo_certificado_id==6 || $request->tipo_certificado_id==7 || $request->tipo_certificado_id==8){
        
        $carne->reevaluacion=0;
      }
      

      $carne->fechacarne="<font style=\"font-size:8pt;\">
EMITIDO: $fechaEmisionC<br>
VENCE: $fechaVenceC</font>";

    }
    else {
      if($request->tipo_certificado_id==5 || $request->tipo_certificado_id==6){
        $carne->reevaluacion=1;
        $fechaRevalidC=date("d/m/Y", strtotime($fec_reevaluacion));
      }
      else {
        //$carne->reevaluacion=0;
      }
      $carne->fechacarne="<font style=\"font-size:8pt;\">
EMITIDO: $fechaEmisionC<br>
REVALIDAR: </font>";
    }
    $carne->nombrescarne="<font style=\"font-size:8pt;\">$persona->nombre $persona->apellido</font>";
    $carne->empresacarne="<font style=\"font-size:8pt;\">$request->empresa</font>";
    $desig='';
    switch($request->tipo_certificado_id){
      case 5: $desig='Operador';
      
          break;
      case 6: $desig='Aparejador';
          break;
      case 7: $desig='Supervisor';

          break;
      case 8: $desig='INSPECTOR';
          break;
    }
    $designacion = Designacion::findOrFail($request->iddesignacion);
    if($request->level=="Basic Level"){ $nivelcarne='Nivel Básico'; $carne->estado=0;}
    elseif($request->level=='Intermediate Level'){ 
      $nivelcarne='Nivel Intermedio';
      if($request->tipo_certificado_id==5 || $request->tipo_certificado_id==6){
        $carne->estado=1;}
      else{
        $carne->estado=0;
      }
           }
    elseif($request->level=="Level 1"){ $nivelcarne='Level 1';$carne->estado=0;}
    elseif($request->level=="Level I"){ $nivelcarne='Level 1';$carne->estado=0;}
    elseif($request->level=="Standard Level"){ $nivelcarne='Nivel Estándar';$carne->estado=0;}
    else{
      $nivelcarne='';
    }
        if($request->cond_equipo==0){
          if($request->tipo_certificado_id==8 || $request->tipo_certificado_id==7){
            $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$desig de $designacion->designacion_espanol 
      </font>";}
          elseif ($request->tipo_certificado_id==12) {
            $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$designacion->designacion_espanol 
      </font><br>
      <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";
          }
              else{
             $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$desig de $designacion->designacion_espanol 
      </font><br><br>
      <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";
              }
        }
        else{
        if($request->tipo_certificado_id==12) {
          $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$designacion->designacion_espanol </font>
          <br>
      <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";
        }
        else{
        $carne->designacioncarne="<font style=\"font-size:8pt;\"><br/>$desig de $designacion->designacion_espanol: 
<br/>$equipocarne</font><br><br>
<font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";}}
    $carne->save();
  }
    
    }
    public function generateCerti(Request $request){
      if(!$request->ajax()) return redirect('/');
      $emision = new Emision();
      $emision->usuario = Auth::user()->nombre.' '.Auth::user()->apellido;
      $emision->idlote=$request->lote_id;
      $emision->save();
      $certificado = Certificado::findOrFail($request->id);
      $persona = Persona::findOrFail($request->persona_id);
      $lote = Lote::findOrFail($request->lote_id);
      
      $qrcode = new Generator;
      $nombre=time().$persona->apellido.'.svg';
      
      
      $certificado->qr=$nombre;
      $certificado->condicion='2';
      $certificado->id_evaluacion='5';      
      if($lote->stock>0){
      $certificado->certificado=$lote->start_code+$lote->cantidad-$lote->stock-1;
      $qr='https://certificado.cicbla.com/verificar?dni='.$persona->dni.'&certificado='.$certificado->certificado;
      $qrcode->format('svg')->size(120)->generate($qr,'../public/qrcodes/'.$nombre);
      $certificado->save();
      }
      //P-'.$numero_cer->certificado.' '.$persona->nombre.' '.$persona->apellido
    }
    public function generateCerti1(Request $request){
      if(!$request->ajax()) return redirect('/');
      
      $certificado = Certificado::findOrFail($request->certificado_id);
      $edicion = Edicion::findOrFail($request->id_edicions);
      $version=$certificado->estado_edi+1;
      $certificado->estado_edi = $version;
      if($edicion->condicion==7){
        $edicion->condicion=4;
      }
      else{
        $edicion->condicion=3;
      }
     
      $certificado->update();
      $edicion->update();
      
    }
    
     public function codigoqr(Request $request){
      $nombre=time().'	Berrocal Torrealba.svg';
      $qrcode = new Generator;
      $qr='https://certificado.cicbla.com/verificar?dni=40902319&certificado=16843';
      $qrcode->format('svg')->size(120)->generate($qr,'../public/qrcodes/'.$nombre);
      $qrcode->format('svg')->size(120)->generate('Make me a QrCode!','../public/qrcodes/qrcodede.svg');
      return view('pdf.qr');
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $certificado = Certificado::findOrFail($request->id);
        $certificado->condicion ='0';
        $certificado->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $certificado = Certificado::findOrFail($request->id);
        $certificado->condicion ='2';
        $certificado->save();
    }
    public function edicion(Request $request)
    {
      
      //dd($request->all());
        if(!$request->ajax()) return redirect('/');
        $edicion = new Edicion();
        $nombre=Auth::user()->nombre;
        $apellido=Auth::user()->apellido;
        $edicion->idcertificado=$request->id;
        $edicion->idusuario =  Auth::user()->id;
        $edicion->solicitante = "$nombre $apellido";
        $edicion->revisor = "";
        $edicion->nombre_empresa = $request->nombre_edi;
        $edicion->designacion = $request->designacion_edi;
        $edicion->otros = $request->normativa_edi;
        $edicion->firma = $request->firma_edi;
        $edicion->foto = $request->foto_edi;
        $edicion->anulacion = $request->anulacion_edi;
        $edicion->cliente = $request->cliente;
        $edicion->comentario = $request->comentario;
        $edicion->condicion = "1";
        
        $edicion->fecha_solicitud =  now();
        //dd($edicion);
        $edicion->save();
    }
    public function edicioncerti(Request $request){
      if(!$request->ajax()) return redirect('/');
        $nombreS =$request->nombreS;
        $solicitante =$request->solicitante;
        $aprobador =$request->aprobador;
        if($nombreS=='' && $solicitante=='' && $aprobador==''){
            $aprobaciones = Edicion::select('edicions.id','edicions.solicitante','edicions.revisor','edicions.nombre_empresa','edicions.designacion','edicions.otros','edicions.horas','edicions.fecha_solicitud','edicions.fecha_aprobacion','edicions.firma','edicions.foto','edicions.carne','edicions.anulacion','edicions.cliente','edicions.comentario','edicions.condicion','certificados.certificado','certificados.pdsi','certificados.designacion as designacion_en','certificados.equipo as equipos_en',
            'certificados.persona','certificados.empresa','certificados.fecha_emision7','personas.dni')
            ->join('certificados','edicions.idcertificado','=','certificados.id')->join('personas','certificados.idpersona','=','personas.id')->where('certificados.sede', '=',1)->orderBy('id','desc')->paginate(10);
        }
        else{
          $aprobaciones = Edicion::select('edicions.id','edicions.solicitante','edicions.revisor','edicions.nombre_empresa','edicions.designacion','edicions.otros','edicions.horas','edicions.fecha_solicitud','edicions.fecha_aprobacion','edicions.firma','edicions.foto','edicions.carne','edicions.anulacion','edicions.cliente','edicions.comentario','edicions.condicion','certificados.certificado','certificados.pdsi','certificados.designacion as designacion_en','certificados.equipo as equipos_en',
          'certificados.persona','certificados.empresa','certificados.fecha_emision7','personas.dni')
          ->join('certificados','edicions.idcertificado','=','certificados.id')->join('personas','certificados.idpersona','=','personas.id')
          ->orderBy('id','desc')->where('edicions.solicitante', 'like', '%'.$solicitante.'%')->where('certificados.certificado', 'like', '%'.$nombreS.'%')->where('edicions.revisor', 'like', '%'.$aprobador.'%')->where('certificados.sede', '=', 1)->orderBy('id','desc')->paginate(10);
        
        }


        return[
            'pagination' => [
                'total'          =>$aprobaciones->total(),
                'current_page'   =>$aprobaciones->currentPage(),
                'per_page'       =>$aprobaciones->perPage(),
                'last_page'      =>$aprobaciones->lastPage(),
                'from'           =>$aprobaciones->firstItem(),
                'to'             =>$aprobaciones->lastItem(),
            ],
            'aprobaciones' => $aprobaciones
        ];
    }
    public function desaprobar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $edicion = Edicion::findOrFail($request->id);
        $edicion->condicion ='0';
        $edicion->horas="0";
        $edicion->fecha_aprobacion=now();
        $nombre=Auth::user()->nombre;
        $apellido=Auth::user()->apellido;
        $edicion->revisor = "$nombre $apellido";
        $edicion->save();
    }
    public function aprobar(Request $request)
    {
      
        if(!$request->ajax()) return redirect('/');
        $estado=2;
        $edicion = Edicion::findOrFail($request->id);
        //dd($edicion);
        //dd($edicion);
        //Configuracion de Condicion 0:No Aprobado 1:en proceseo 2:solo ediCerti 3:cerrado ediCerti abierto ediCarne
        //4:cerrar todas las ediciones 5:solo edi Carne 6:anuladi
        if(($edicion->nombre_empresa=="" || $edicion->nombre_empresa=="false") && ($edicion->designacion=="" || $edicion->designacion=="false") && ($edicion->otros=="" || $edicion->otros=="false") && ($edicion->firma=="" || $edicion->firma=="false")){
          $estado=5;
        }
        //dd($estado);
        if($edicion->nombre_empresa=="false" && $edicion->designacion=="false" && $edicion->otros=="false" && $edicion->firma=="false"){
          $estado=5;
        }
        if(($edicion->anulacion=="" || $edicion->anulacion=="false") && ($edicion->foto=="" || $edicion->foto=="false") && ($edicion->nombre_empresa=="" || $edicion->nombre_empresa=="false") && ($edicion->designacion=="" || $edicion->designacion=="false") && ($edicion->otros=="" || $edicion->otros=="false")){
          $estado=7;
        }
        if($edicion->anulacion=="true"){
          $certificado = Certificado::findOrFail($edicion->idcertificado);
          $certificado->condicion ='0';
          $certificado->update();
          $estado=6;
        }
        $edicion->condicion =$estado;
        $edicion->horas="8";
        $edicion->fecha_aprobacion=now();
        $nombre=Auth::user()->nombre;
        $apellido=Auth::user()->apellido;
        $edicion->revisor = "$nombre $apellido";
        $edicion->save();
    }
    public function emitirCarne1(Request $request){
      if(!$request->ajax()) return redirect('/');
      //dd($request->all());
      $edicion=Edicion::find($request->edicion);
      $edicion->condicion=4;
      $edicion->update();
      $carne = Carne::findOrFail($request->id);
      $carne->idusuario=Auth::user()->id;
      $carne->nombrescarne=$request->nombrescarne;
      $carne->empresacarne=$request->empresacarne;
      $carne->designacioncarne=$request->designacioncarne;
      $carne->fechacarne=$request->fechacarne;
      if($request->foto==''){

      }
      else{
        $carne->foto=$request->foto;
      }
      
      if($carne->estado==0){
        //$carne->estado=2;
      }
      elseif($carne->estado==1){
        if($carne->reevaluacion==0){
          //$carne->estado=2;
        }
        else{
          //$carne->estado=3;
        }
        
      }
      $carne->save();
    }
}
