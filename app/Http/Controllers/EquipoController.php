<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Equipo;
use App\Dato_Equipo;
use App\Cliente;
use App\Persona;
use App\Tipo_Equipo;
use App\Firma;
use SimpleSoftwareIO\QrCode\Generator;
use PDF;

class EquipoController extends Controller
{
    public function index(Request $request)
    {  
        //if(!$request->ajax()) return redirect('/');
        $pdsi = $request->bpdsi;
        $empresa = $request->bempresa;
        $modelo =$request->bmodelo;
        $numero=$request->bnumero;
        $equipo = $request->bequipo;
        $serie=$request->bserie;
        $vigencia=$request->bvigencia;
        if($empresa=='' && $modelo=='' && $numero=='' && $equipo=='' && $serie=='' && $vigencia=="0"){
          //dd("aqui");
            $equipos = Equipo::join('clientes as c','c.id','=','certificado_equipo.id_cliente')->
            join('dato_equipo as d','d.id','=','certificado_equipo.id_equipo')->
            join('tipo_equipo as t','t.id','=','d.id_tipo_equipo')->
            select('c.id as id_cliente','c.cliente','certificado_equipo.id','certificado_equipo.certificado','certificado_equipo.fecha_inspeccion','certificado_equipo.fecha_emision'
            ,'certificado_equipo.lugar','certificado_equipo.fecha_inspeccion2','certificado_equipo.fecha_expiracion',
            't.id as id_tipo_equipo','t.tipo_equipo','certificado_equipo.propietario','d.id as id_dato_equipo','d.marca','d.modelo','d.serie','d.cod_interno','d.fabricante',
            'd.anio','certificado_equipo.campo1','certificado_equipo.resultado1','certificado_equipo.campo2','certificado_equipo.resultado2',
            'certificado_equipo.normativa','certificado_equipo.capa_maxima','certificado_equipo.peso_certificacion','certificado_equipo.tasa_prueba',
            'certificado_equipo.longitud_pluma','certificado_equipo.angulo_pluma','certificado_equipo.ruta_certi_fisi','certificado_equipo.radio_opera','certificado_equipo.informe',
            'certificado_equipo.vigencia','certificado_equipo.estado','certificado_equipo.id_firma2','certificado_equipo.separador','certificado_equipo.id_firma')->OrderBy('certificado_equipo.id','desc')->paginate(50);
        }
        else{
            $equipos= Equipo::join('clientes as c','c.id','=','certificado_equipo.id_cliente')->
            join('dato_equipo as d','d.id','=','certificado_equipo.id_equipo')->
            join('tipo_equipo as t','t.id','=','d.id_tipo_equipo')->
            select('c.id as id_cliente','c.cliente','certificado_equipo.id','certificado_equipo.certificado','certificado_equipo.fecha_inspeccion','certificado_equipo.fecha_emision'
            ,'certificado_equipo.lugar','certificado_equipo.fecha_inspeccion2','certificado_equipo.fecha_expiracion',
            't.id as id_tipo_equipo','t.tipo_equipo','certificado_equipo.propietario','d.id as id_dato_equipo','d.marca','d.modelo','d.serie','d.cod_interno','d.fabricante',
            'd.anio','certificado_equipo.campo1','certificado_equipo.resultado1','certificado_equipo.campo2','certificado_equipo.resultado2',
            'certificado_equipo.normativa','certificado_equipo.capa_maxima','certificado_equipo.peso_certificacion','certificado_equipo.tasa_prueba',
            'certificado_equipo.longitud_pluma','certificado_equipo.angulo_pluma','certificado_equipo.ruta_certi_fisi','certificado_equipo.radio_opera','certificado_equipo.informe',
            'certificado_equipo.vigencia','certificado_equipo.estado','certificado_equipo.id_firma2','certificado_equipo.separador','certificado_equipo.id_firma')->where('c.cliente', 'like', '%'.$empresa.'%')
            ->where('d.modelo', 'like', '%'.$modelo.'%')->where('certificado_equipo.certificado', 'like', '%'.$numero.'%')
            ->where('t.tipo_equipo', 'like', '%'.$equipo.'%')->where('d.serie', 'like', '%'.$serie.'%');
           // dd($vigencia);
            if ($vigencia == "1") {
                $equipos->where('certificado_equipo.fecha_expiracion', '>', now());
            } elseif ($vigencia == "2") {
                $equipos->where('certificado_equipo.fecha_expiracion', '<', now());
            }
            $equipos = $equipos->orderBy('certificado_equipo.id', 'desc')->paginate(50);
        }
        return[
            'pagination' => [
                'total'          =>$equipos->total(),
                'current_page'   =>$equipos->currentPage(),
                'per_page'       =>$equipos->perPage(),
                'last_page'      =>$equipos->lastPage(),
                'from'           =>$equipos->firstItem(),
                'to'             =>$equipos->lastItem(),
            ],
            'equipos' => $equipos
        ];
    }
    public function indexCliente(Request $request)
    {  
        //if(!$request->ajax()) return redirect('/');
        $indi = 0;
        $pdsi = $request->bpdsi;
        $empresa = $request->bempresa;
        $modelo =$request->bmodelo;
        $numero=$request->bnumero;
        $equipo = $request->bequipo;
        $serie=$request->bserie;
        $persona=Persona::where('usua_web','=',Auth::user()->id)->first();
        //dd($persona);
        
        if($persona){
          $indi=1;
          $idCliente=$persona->cli_id;
          $cliente=Cliente::find($idCliente);
          //dd($cliente);
          $empresa=$cliente->cliente;
        }

        if($empresa=='' && $modelo=='' && $numero=='' && $equipo=='' && $serie==''){
            $equipos = Equipo::join('clientes as c','c.id','=','certificado_equipo.id_cliente')->
            join('dato_equipo as d','d.id','=','certificado_equipo.id_equipo')->
            join('tipo_equipo as t','t.id','=','d.id_tipo_equipo')->
            select('c.id as id_cliente','c.cliente','certificado_equipo.id','certificado_equipo.certificado','certificado_equipo.fecha_inspeccion','certificado_equipo.fecha_emision'
            ,'certificado_equipo.lugar','certificado_equipo.fecha_inspeccion2','certificado_equipo.fecha_expiracion',
            't.id as id_tipo_equipo','t.tipo_equipo','certificado_equipo.propietario','d.id as id_dato_equipo','d.marca','d.modelo','d.serie','d.cod_interno','d.fabricante',
            'd.anio','certificado_equipo.campo1','certificado_equipo.resultado1','certificado_equipo.campo2','certificado_equipo.resultado2',
            'certificado_equipo.normativa','certificado_equipo.capa_maxima','certificado_equipo.peso_certificacion','certificado_equipo.tasa_prueba',
            'certificado_equipo.longitud_pluma','certificado_equipo.angulo_pluma','certificado_equipo.ruta_certi_fisi','certificado_equipo.radio_opera','certificado_equipo.informe',
            'certificado_equipo.vigencia','certificado_equipo.estado','certificado_equipo.id_firma2','certificado_equipo.separador','certificado_equipo.id_firma')->OrderBy('certificado_equipo.id','desc')->paginate(50);
        }
        else{
            $equipos= Equipo::join('clientes as c','c.id','=','certificado_equipo.id_cliente')->
            join('dato_equipo as d','d.id','=','certificado_equipo.id_equipo')->
            join('tipo_equipo as t','t.id','=','d.id_tipo_equipo')->
            select('c.id as id_cliente','c.cliente','certificado_equipo.id','certificado_equipo.certificado','certificado_equipo.fecha_inspeccion','certificado_equipo.fecha_emision'
            ,'certificado_equipo.lugar','certificado_equipo.fecha_inspeccion2','certificado_equipo.fecha_expiracion',
            't.id as id_tipo_equipo','t.tipo_equipo','certificado_equipo.propietario','d.id as id_dato_equipo','d.marca','d.modelo','d.serie','d.cod_interno','d.fabricante',
            'd.anio','certificado_equipo.campo1','certificado_equipo.resultado1','certificado_equipo.campo2','certificado_equipo.resultado2',
            'certificado_equipo.normativa','certificado_equipo.capa_maxima','certificado_equipo.peso_certificacion','certificado_equipo.tasa_prueba',
            'certificado_equipo.longitud_pluma','certificado_equipo.angulo_pluma','certificado_equipo.ruta_certi_fisi','certificado_equipo.radio_opera','certificado_equipo.informe',
            'certificado_equipo.vigencia','certificado_equipo.estado','certificado_equipo.id_firma2','certificado_equipo.separador','certificado_equipo.id_firma')->where('c.cliente', 'like', '%'.$empresa.'%')
            ->where('d.modelo', 'like', '%'.$modelo.'%')->where('certificado_equipo.certificado', 'like', '%'.$numero.'%')
            ->where('t.tipo_equipo', 'like', '%'.$equipo.'%')->where('d.serie', 'like', '%'.$serie.'%')
            ->orderBy('id','desc')->OrderBy('certificado_equipo.id','desc')->paginate(50);
        }
        return[
            'pagination' => [
                'total'          =>$equipos->total(),
                'current_page'   =>$equipos->currentPage(),
                'per_page'       =>$equipos->perPage(),
                'last_page'      =>$equipos->lastPage(),
                'from'           =>$equipos->firstItem(),
                'to'             =>$equipos->lastItem(),
            ],
            'equipos' => $equipos,
            'cliente' => $empresa,
            'indi' => $indi
        ];
    }
    public function certificadoPdf(Request $request,$id){
        //if(!$request->ajax()) return redirect('/');
        $qrcode = new Generator;
        $data = $qrcode->format('svg')->size(399)->color(40,40,40)->generate('Make me a QrCode!','../public/qrcodes/qrcode.svg');
        $certificados = Equipo::join('clientes as c','c.id','=','certificado_equipo.id_cliente')->
        join('dato_equipo as d','d.id','=','certificado_equipo.id_equipo')->
        join('tipo_equipo as t','t.id','=','d.id_tipo_equipo')->
        join('firmas','certificado_equipo.id_firma','=','firmas.id')->
        select('c.id as id_cliente','c.cliente','certificado_equipo.id','certificado_equipo.certificado','certificado_equipo.fecha_inspeccion','certificado_equipo.fecha_emision'
        ,'certificado_equipo.lugar','certificado_equipo.fecha_inspeccion2','certificado_equipo.fecha_expiracion',
        't.id as id_tipo_equipo','t.tipo_equipo','t.tipo_certificado','certificado_equipo.propietario','d.id as id_dato_equipo','d.marca','d.modelo','d.serie','d.cod_interno','d.fabricante',
        'd.anio','d.capacidad','certificado_equipo.campo1','certificado_equipo.resultado1','certificado_equipo.campo2','certificado_equipo.resultado2',
        'certificado_equipo.normativa','certificado_equipo.capa_maxima','certificado_equipo.peso_certificacion','certificado_equipo.tasa_prueba',
        'certificado_equipo.longitud_pluma','certificado_equipo.angulo_pluma','certificado_equipo.radio_opera','certificado_equipo.informe',
        'certificado_equipo.vigencia','certificado_equipo.estado','certificado_equipo.id_firma2','certificado_equipo.id_firma')
          ->where('certificado_equipo.id','=', $id)->OrderBy('certificado_equipo.id','desc')->get();
          //dd($certificados);
          //PDF::SetProtection(array('modify','copy','print'), '', null, 0, null);
          PDF::SetTitle('Vista Previa');
          
          PDF::SetFont('times');
          PDF::setCellHeightRatio(1);
          $width = 210;  
          $height = 297; 
          PDF::SetMargins(0, 0, 0);
          PDF::SetHeaderMargin(0);
          PDF::SetFooterMargin(0);
          PDF::AddPage('P',array($height,$width));
          
          // get the current page break margin
          $bMargin = PDF::getBreakMargin();
          // get current auto-page-break mode
          $auto_page_break = PDF::getAutoPageBreak();
          // disable auto-page-break
          PDF::SetAutoPageBreak(false, 0);
          // set bacground image
          $img_file = 'img/CertificadoPersonaPiePagina.png';
          PDF::Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
          PDF::SetAlpha(0.3); 
          
          PDF::SetAlpha(1); 
          // restore auto-page-break status
          PDF::SetAutoPageBreak($auto_page_break, $bMargin);
          // Añade un texto (posición X, posición Y, texto)
          // set the starting point for the page content
          PDF::setPageMark();
          PDF::setPrintHeader(false);
          PDF::SetFooterMargin(-20);
          PDF::setPrintFooter(false);
          
          $html=view('pdf.equipoPdf',['certificados' => $certificados,'data' => $data])->render();  
          // Calcular el tamaño de la página
            
          PDF::writeHTML($html, true, true, true, true, '');
       
          
  
          PDF::Output('PDF VISTA PREVIA.pdf', 'I');
      }

      public function certificadoPdfEmision(Request $request,$id){
        //if(!$request->ajax()) return redirect('/');
        $qrcode = new Generator;
        //$data = $qrcode->format('svg')->size(399)->color(40,40,40)->generate('Make me a QrCode!','../public/qrcodes/qrcode.svg');
        $certificados = Equipo::join('clientes as c','c.id','=','certificado_equipo.id_cliente')->
        join('dato_equipo as d','d.id','=','certificado_equipo.id_equipo')->
        join('tipo_equipo as t','t.id','=','d.id_tipo_equipo')->
        join('firmas','certificado_equipo.id_firma','=','firmas.id')->
        select('c.id as id_cliente','c.cliente','certificado_equipo.id','certificado_equipo.certificado','certificado_equipo.fecha_inspeccion','certificado_equipo.fecha_emision'
        ,'certificado_equipo.lugar','certificado_equipo.fecha_inspeccion2','certificado_equipo.fecha_expiracion',
        't.id as id_tipo_equipo','t.tipo_equipo','t.tipo_certificado','certificado_equipo.propietario','d.id as id_dato_equipo','d.marca','d.modelo','d.serie','d.cod_interno','d.fabricante',
        'd.anio','d.capacidad','certificado_equipo.campo1','certificado_equipo.resultado1','certificado_equipo.campo2','certificado_equipo.resultado2',
        'certificado_equipo.normativa','certificado_equipo.capa_maxima','certificado_equipo.peso_certificacion','certificado_equipo.tasa_prueba',
        'certificado_equipo.longitud_pluma','certificado_equipo.angulo_pluma','certificado_equipo.radio_opera','certificado_equipo.informe',
        'certificado_equipo.vigencia','certificado_equipo.estado','certificado_equipo.id_firma2','certificado_equipo.id_firma','firmas.nombre as firma_nombre','firmas.imagen')
          ->where('certificado_equipo.id','=', $id)->OrderBy('certificado_equipo.id','desc')->get();
          $num= Equipo::findOrFail($id);
          
          PDF::SetProtection(array('copy','modify'), '', null, 0, null);

          PDF::SetTitle($num->certificado);
          PDF::SetFont('times');
          PDF::setCellHeightRatio(1);
          $width = 210;  
          $height = 297; 
          PDF::SetMargins(0, 0 , 0);
          PDF::AddPage('P',array($height,$width));
          // -- set new background ---
  
          // get the current page break margin
          $bMargin = PDF::getBreakMargin();
          // get current auto-page-break mode
          $auto_page_break = PDF::getAutoPageBreak();
          // disable auto-page-break
          PDF::SetAutoPageBreak(false, 0);
          if($num->id_firma2===null){
            $firma = Firma::findOrFail($num->id_firma);
            $firmacarne = 'storage/'.$firma->imagen;
            PDF::Image($firmacarne,  55, 235+$num->separador, 50, 40, '', '', '', false, 300, '', false, false, 0);
            $img_file='img/Sello.png';
            PDF::Image($img_file, 113, 245, 25, 25, '', '', '', false, 300, '', false, false, 0);
          }
          else{
            $firma = Firma::findOrFail($num->id_firma);
            $firmacarne = 'storage/'.$firma->imagen;
            PDF::Image($firmacarne,  40, 235+$num->separador, 42, 32, '', '', '', false, 300, '', false, false, 0);
            $firma = Firma::findOrFail($num->id_firma);
            $firmacarne = 'storage/'.$firma->imagen;
            PDF::Image($firmacarne,  103, 235+$num->separador, 42, 32, '', '', '', false, 300, '', false, false, 0);
            
            $img_file='img/Sello.png';
            PDF::Image($img_file, 81, 240+$num->separador, 25, 25, '', '', '', false, 300, '', false, false, 0);
            
          }
          //dd($firmacarne);
          // set bacground image
          $img_file = 'img/CertificadoPersonaPiePagina.png';

          PDF::Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
          
          //PDF::Image($fondo, 0, 0, 279, 216, '', '', '', false, 300, '', false, false, 0);
          $qr='qrcodes/equipo/'.$num->qr;
          PDF::ImageSVG($qr, 58, 10, 24, 24, '', '', '', false, 300, '', false, false, 0);
          //$diferecia = (50-$num->separacion)/10;
          //PDF::ImageSVG($firmacarne, 55, 230, 40, 40, '', '', '', false, 300, '', false, false, 0);
          //Sello
          
          //PDF::Image($logo, 10, 190, 95, '', '', '', '', false, 300, '', false, false, 0);
         
          //PDF::Image($texto, 145, 114.5, 111.5, 16.5, '', '', '', false, 300, '', false, false, 0);
          //PDF::Image($encabezado, 46, 25, 190, 87.3, '', '', '', false, 300, '', false, false, 0);
          // restore auto-page-break status
          PDF::SetAutoPageBreak($auto_page_break, $bMargin);
          // set the starting point for the page content
          PDF::setPageMark();
          PDF::setPrintHeader(false);
          PDF::SetFooterMargin(0);
          PDF::setPrintFooter(false);
          //dd($certificados);
          PDF::writeHTML(view('pdf.certificadoEquipoPdfEmision',['certificados' => $certificados])->render());
          
          $filename = $num->certificado.'.pdf';
          
          
          //$filename = 'B-00'.$num->certificado.' '.$num->persona.'.pdf';
          
          //PDF::addEmptySignatureAppearance(222, 41, 45, 20);
          //PDF::setFont('times', '', 12);
          
          
          PDF::Output($filename, 'I');
          
  /*
          $pdf = \PDF::loadView('pdf.certificadopdfEmision',['certificados' => $certificados,'data' => $data])->setPaper('letter', 'landscape');
          ini_set("memory_limit","128M"); 
          $num= Certificado::findOrFail($id);
          $name='P-'.$num->certificado.' '.$num->persona.'.pdf';
          return $pdf->stream($name,array("Attachment" => 0));
          */
      }
      public function certificadoPdfEmisionSinFondo(Request $request,$id){
        //if(!$request->ajax()) return redirect('/');
        $qrcode = new Generator;
        //$data = $qrcode->format('svg')->size(399)->color(40,40,40)->generate('Make me a QrCode!','../public/qrcodes/qrcode.svg');
        $certificados = Equipo::join('clientes as c','c.id','=','certificado_equipo.id_cliente')->
        join('dato_equipo as d','d.id','=','certificado_equipo.id_equipo')->
        join('tipo_equipo as t','t.id','=','d.id_tipo_equipo')->
        join('firmas','certificado_equipo.id_firma','=','firmas.id')->
        select('c.id as id_cliente','c.cliente','certificado_equipo.id','certificado_equipo.certificado','certificado_equipo.fecha_inspeccion','certificado_equipo.fecha_emision'
        ,'certificado_equipo.lugar','certificado_equipo.fecha_inspeccion2','certificado_equipo.fecha_expiracion',
        't.id as id_tipo_equipo','t.tipo_equipo','t.tipo_certificado','certificado_equipo.propietario','d.id as id_dato_equipo','d.marca','d.modelo','d.serie','d.cod_interno','d.fabricante',
        'd.anio','d.capacidad','certificado_equipo.campo1','certificado_equipo.resultado1','certificado_equipo.campo2','certificado_equipo.resultado2',
        'certificado_equipo.normativa','certificado_equipo.capa_maxima','certificado_equipo.peso_certificacion','certificado_equipo.tasa_prueba',
        'certificado_equipo.longitud_pluma','certificado_equipo.angulo_pluma','certificado_equipo.radio_opera','certificado_equipo.informe',
        'certificado_equipo.vigencia','certificado_equipo.estado','certificado_equipo.id_firma2','certificado_equipo.id_firma','firmas.nombre as firma_nombre','firmas.imagen')
          ->where('certificado_equipo.id','=', $id)->OrderBy('certificado_equipo.id','desc')->get();
          $num= Equipo::findOrFail($id);
          
          PDF::SetProtection(array('copy','modify'), '', null, 0, null);

          PDF::SetTitle($num->certificado);
          PDF::SetFont('times');
          PDF::setCellHeightRatio(1);
          $width = 210;  
          $height = 297; 
          PDF::SetMargins(0, 0 , 0);
          PDF::AddPage('P',array($height,$width));
          // -- set new background ---
  
          // get the current page break margin
          $bMargin = PDF::getBreakMargin();
          // get current auto-page-break mode
          $auto_page_break = PDF::getAutoPageBreak();
          // disable auto-page-break
          PDF::SetAutoPageBreak(false, 0);
          
          if($num->id_firma2===null){
            $firma = Firma::findOrFail($num->id_firma);
            $firmacarne = 'storage/'.$firma->imagen2;
            PDF::Image($firmacarne,  55, 235+$num->separador, 50, 40, '', '', '', false, 300, '', false, false, 0);
            
          }
          else{
            $firma = Firma::findOrFail($num->id_firma);
            $firmacarne = 'storage/'.$firma->imagen2;
            PDF::Image($firmacarne,  40, 235+$num->separador, 42, 32, '', '', '', false, 300, '', false, false, 0);
            $firma = Firma::findOrFail($num->id_firma2);
            $firmacarne = 'storage/'.$firma->imagen2;
            PDF::Image($firmacarne,  103, 235+$num->separador, 42, 32, '', '', '', false, 300, '', false, false, 0);
            
          }//dd($firmacarne);
          // set bacground image
          $img_file = 'img/CertificadoPersonaSinFondo.png';
          PDF::Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
          
          //PDF::Image($fondo, 0, 0, 279, 216, '', '', '', false, 300, '', false, false, 0);
          $qr='qrcodes/equipo/'.$num->qr;
          PDF::ImageSVG($qr, 58, 10, 24, 24, '', '', '', false, 300, '', false, false, 0);
          //$diferecia = (50-$num->separacion)/10;
          //PDF::ImageSVG($firmacarne, 55, 230, 40, 40, '', '', '', false, 300, '', false, false, 0);
          
          
         
          //PDF::Image($texto, 145, 114.5, 111.5, 16.5, '', '', '', false, 300, '', false, false, 0);
          //PDF::Image($encabezado, 46, 25, 190, 87.3, '', '', '', false, 300, '', false, false, 0);
          // restore auto-page-break status
          PDF::SetAutoPageBreak($auto_page_break, $bMargin);
          // set the starting point for the page content
          PDF::setPageMark();
          PDF::setPrintHeader(false);
          PDF::SetFooterMargin(0);
          PDF::setPrintFooter(false);
          //dd($certificados);
          PDF::writeHTML(view('pdf.certificadoEquipoPdfEmision',['certificados' => $certificados])->render());
          
          $filename = $num->certificado.'.pdf';
          
          
          //$filename = 'B-00'.$num->certificado.' '.$num->persona.'.pdf';
          
          //PDF::addEmptySignatureAppearance(222, 41, 45, 20);
          //PDF::setFont('times', '', 12);
          
          
          PDF::Output($filename, 'I');
          
  /*
          $pdf = \PDF::loadView('pdf.certificadopdfEmision',['certificados' => $certificados,'data' => $data])->setPaper('letter', 'landscape');
          ini_set("memory_limit","128M"); 
          $num= Certificado::findOrFail($id);
          $name='P-'.$num->certificado.' '.$num->persona.'.pdf';
          return $pdf->stream($name,array("Attachment" => 0));
          */
      }
      
      
    public function store(Request $request)
    {   
        $equipos = new Equipo();
        $equipos->idusuario = Auth::user()->id;
        $equipos->id_cliente=$request->idClienteN;
        $equipos->certificado='ABC-1234';
        $equipos->lugar=$request->lugar;
        $equipos->fecha_inspeccion=$request->fecha_inspeccion;
        $equipos->fecha_inspeccion2=$request->fecha_certificado;
        $equipos->fecha_expiracion=$request->fecha_vencimiento;
        $equipos->fecha_emision=$request->fecha_Emision;
        $equipos->id_equipo=$request->idEquipoN;
        $equipos->propietario=$request->propietario;
        $equipos->campo1=$request->campo1;
        $equipos->resultado1=$request->respuesta1;
        $equipos->campo2=$request->campo2;
        $equipos->resultado2=$request->respuesta2;
        $equipos->capa_maxima=$request->capacidad_nominal;
        $equipos->peso_certificacion=$request->peso_certi;
        $equipos->tasa_prueba=$request->tasa_prueba;
        $equipos->longitud_pluma=$request->longitud_pluma;
        $equipos->angulo_pluma=$request->angulo_pluma;
        $equipos->radio_opera=$request->radio_operativo;
        $equipos->informe=$request->informe;
        $equipos->vigencia=$request->vigenciaTexto;
        $equipos->id_firma=$request->firma_id;
        $equipos->id_firma2=$request->firma_id2;
        $equipos->separador=$request->separador;
        $equipos->normativa=$request->normativa;
        if($request->hasFile('archivo')){
          $name = time().$request->file('archivo')->getClientOriginalName();
          $pathToFile = $request->file('archivo')->storeAs('archivo',$name,'public');
          $equipos->ruta_certi_fisi=$pathToFile;
            
        }
        else{
            $pathToFile='';
        }
      
        // Generar Código QR
        /*$qrcode = new Generator;
        $nombre=time().'.svg';
        $qr='https://certificado.cicbla.com/equipment?ruc='.$request->ruc.'&serie='.$request->serie.'&pdsi='.$request->pdsi;
        $qrcode->format('svg')->size(120)->generate($qr,'../public/qrcodes/equipo/'.$nombre);
        */$equipos->qr="1";
        $equipos->estado=1;
        $equipos->save();
        

    }

    public function update(Request $request)
    {      //dd($request->all());  
      $equipos = Equipo::findOrFail($request->id);
      //dd($equipos); 
      $equipos->id_cliente=$request->idClienteN;
        //$equipos->certificado='ABC-1234';
        $equipos->lugar=$request->lugar;
        $equipos->fecha_inspeccion=$request->fecha_inspeccion;
        $equipos->fecha_inspeccion2=$request->fecha_certificado;
        $equipos->fecha_expiracion=$request->fecha_vencimiento;
        $equipos->fecha_emision=$request->fecha_Emision;
        $equipos->id_equipo=$request->idEquipoN;
        $equipos->propietario=$request->propietario;
        $equipos->campo1=$request->campo1;
        $equipos->resultado1=$request->respuesta1;
        $equipos->campo2=$request->campo2;
        $equipos->resultado2=$request->respuesta2;
        $equipos->capa_maxima=$request->capacidad_nominal;
        $equipos->peso_certificacion=$request->peso_certi;
        $equipos->tasa_prueba=$request->tasa_prueba;
        $equipos->longitud_pluma=$request->longitud_pluma;
        $equipos->angulo_pluma=$request->angulo_pluma;
        $equipos->radio_opera=$request->radio_operativo;
        $equipos->informe=$request->informe;
        $equipos->vigencia=$request->vigenciaTexto;
        $equipos->id_firma=$request->firma_id;
        if($request->firma_id2!==null)
        $equipos->id_firma2=$request->firma_id2;

        $equipos->normativa=$request->normativa;

        if($request->separador!==null)
        $equipos->separador=$request->separador;
        if($request->hasFile('archivo')){
          $name = time().$request->file('archivo')->getClientOriginalName();
          $pathToFile = $request->file('archivo')->storeAs('archivo',$name,'public');
          $equipos->ruta_certi_fisi=$pathToFile;
            
        }
        else{
            $pathToFile='';
        }
      $equipos->save();
      return $equipos;
    }

    public function emitirCertificado(Request $request)
    {
      //dd($request->all());  
      if(!$request->ajax())return redirect('/');
        $equipos = Equipo::findOrFail($request->id);
        $datoEquipo = Dato_Equipo::findOrFail($equipos->id_equipo);
        $tipoEquipo = Tipo_Equipo::findOrFail($datoEquipo->id_tipo_equipo);
        $equipos->estado = 2;
        $empresa=Cliente::find($equipos->id_cliente);
        $count=Equipo::join('dato_equipo as d','d.id','=','certificado_equipo.id_equipo')->
        join('tipo_equipo as t','t.id','=','d.id_tipo_equipo')->
        where('t.id','=',$datoEquipo->id_tipo_equipo)->where('certificado_equipo.id_cliente','=',$equipos->id_cliente)->where('fecha_inspeccion','=',$equipos->fecha_inspeccion)->count();
        $numCo=str_pad($count, 3, '0', STR_PAD_LEFT);
          $mes7=str_pad(date('n',strtotime($equipos->fecha_inspeccion)), 2, '0', STR_PAD_LEFT);
          
          $dia7=date('d',strtotime($equipos->fecha_inspeccion));
          $ano7=date('y',strtotime($equipos->fecha_inspeccion));
      $codigo = "CE-$empresa->iniciales_cliente$ano7$mes7$dia7-$empresa->codigo_cliente$tipoEquipo->cod_tipo_cert$numCo";
      //dd($codigo);
       $equipos->certificado = $codigo;
       $qrcode = new Generator;
        $nombre=time().'.svg';
        $qr='https://certificado.cericorp.com/verificarEquipo?serie='.$request->serie.'&certificado='.$codigo;
        $qrcode->format('svg')->size(120)->generate($qr,'../public/qrcodes/equipo/'.$nombre);
        $equipos->qr = $nombre;
        $equipos->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $equipos = Equipo::findOrFail($request->id);
        $equipos->estado = '0';
        $equipos->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $equipos = Equipo::findOrFail($request->id);
        $equipos->estado = '2';
        $equipos->save();
    }
    
}
