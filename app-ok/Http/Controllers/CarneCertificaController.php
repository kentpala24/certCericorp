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
use PDF;

class CarneCertificaController extends Controller
{
    public function carnePdf(Request $request,$id){
        //if(!$request->ajax()) return redirect('/');
        $qrcode = new Generator;
        $data = $qrcode->format('svg')->size(399)->color(40,40,40)->generate('Make me a QrCode!','../public/qrcodes/qrcode.svg');
        $carnes = Carne::join('users','carnes.idusuario','=','users.id')->
          join('designacions','carnes.iddesignacion','=','designacions.id')->
          join('certificados','carnes.idcertificado','=','certificados.id')->
          join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
          join('personas','certificados.idpersona','=','personas.id')->
          select('users.nombre as usuario_nombre','users.apellido as usuario_apellido',
          'certificados.id','certificados.pdsi','personas.dni','certificados.empresa','certificados.certificado',
          'certificados.persona','certificados.empresa','certificados.certificado','certificados.equipo','certificados.cond_equipo',
          'tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','tipo_certificados.nombre_min',
          'certificados.level','certificados.normativa','certificados.qr','certificados.condicion','certificados.fecha_emision7',
          'certificados.fecha_revalidacion','certificados.fecha_expiracion',
          'carnes.foto','carnes.designacion_espanol','carnes.equipo_espanol','carnes.normativa_espanol',
          'carnes.nombrescarne','carnes.empresacarne','carnes.designacioncarne','carnes.fechacarne','carnes.estado','carnes.fecha_reevaluacion','carnes.reevaluacion',
          'designacions.identifica','designacions.color','designacions.identifica','designacions.color','designacions.identifica_ingles')->where('carnes.id','=', $id)->where('certificados.condicion','>=', 1)->OrderBy('certificado','desc')->get();
          
          //PDF::SetProtection(array('copy','print'), '', null, 0, null);
          PDF::SetTitle('Vista Previa - Carne');
          PDF::SetFont('helvetica','',10);
          PDF::setCellHeightRatio(1);
          $width = 85.725;  
          $height = 53.975; 
          PDF::SetMargins(0, 0 , 0);
          PDF::AddPage('L',array($width,$height));
          PDF::SetHeaderMargin(1);
          PDF::setPrintHeader(false);
          $bMargin = PDF::getBreakMargin();
          // get current auto-page-break mode
          $auto_page_break = PDF::getAutoPageBreak();
          // disable auto-page-break
          PDF::SetAutoPageBreak(false, 0);
          
          // set bacground image
          $num= Carne::findOrFail($id);
          $certifi= Certificado::findOrFail($num->idcertificado);
          $perso=Persona::findOrFail($certifi->idpersona);
          $img_file = 'img/Carne/carnet.png';
          PDF::Image($img_file, -0.15, 0, 85.8, 54.6, '', '', '', false, 300, '', false, false, 0);
          
          $img_file2 = 'storage/'.$num->foto;
          PDF::Image($img_file2, 5.2  , 10.95, 21.4, 26.2, '', '', '', false, 300, '', false, false, 0);
          // --- Rotation --------------------------------------------
           PDF::StartTransform(); 
           
          $carnenum=$perso->dni.'-'.$certifi->certificado;
          $num_caracte = strlen($perso->dni);
          if($num_caracte>8){
          PDF::Rotate(90,21, 17.5); 
          }
          else{
              PDF::Rotate(90,18.3, 14); 
          }
          PDF::SetFont ("helvetica", "", 6 , "", "default", true );
          
          PDF::Text(0, 1, '',false,false,true,0,0,'',0,'',0);
          PDF::StopTransform();
          
          $hola=0;
          // restore auto-page-break status
          PDF::SetAutoPageBreak(true, 1);
          PDF::writeHTML(view('pdf.carneCpdf',['carnes' => $carnes,'data' => $data,'hola'=>$hola])->render(),true, false, false, false, '');
         
          //Page2
          PDF::AddPage('L',array($width,$height));
            $bMargin = PDF::getBreakMargin();
        // get current auto-page-break mode
            $auto_page_break = PDF::getAutoPageBreak();
        // disable auto-page-break

        PDF::SetAutoPageBreak(false, 0);
        // set bacground image
        $color= Designacion::findOrFail($num->iddesignacion);
        $img_file3 ='img/Carne/carnet2.png';
        PDF::Image($img_file3, -0.15, 0, 88, 54.6, '', '', '', false, 300, '', false, false, 0);
        //Empresa Posiscisión vertical
        $hola=0;
        // restore auto-page-break status
        PDF::SetAutoPageBreak(true, 1);
        PDF::writeHTML(view('pdf.carneC2pdf',['carnes' => $carnes,'data' => $data,'hola'=>$hola])->render(),true, true, true, true, '');         
        


        PDF::Output('PDF VISTA PREVIA.pdf', 'I');
      }
      
      public function carneEmisionPdf(Request $request,$id){
        //if(!$request->ajax()) return redirect('/');
        $qrcode = new Generator;
        $data = $qrcode->format('svg')->size(399)->color(40,40,40)->generate('Make me a QrCode!','../public/qrcodes/qrcode.svg');
        $carnes = Carne::join('users','carnes.idusuario','=','users.id')->
          join('designacions','carnes.iddesignacion','=','designacions.id')->
          join('certificados','carnes.idcertificado','=','certificados.id')->
          join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
          join('personas','certificados.idpersona','=','personas.id')->
          select('users.nombre as usuario_nombre','users.apellido as usuario_apellido',
          'certificados.id','certificados.pdsi','personas.dni','certificados.empresa','certificados.certificado',
          'certificados.persona','certificados.empresa','certificados.certificado','certificados.equipo','certificados.cond_equipo',
          'tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados','tipo_certificados.nombre_min',
          'certificados.level','certificados.normativa','certificados.qr','certificados.condicion','certificados.fecha_emision7',
          'certificados.fecha_revalidacion','certificados.fecha_expiracion',
          'carnes.foto','carnes.designacion_espanol','carnes.equipo_espanol','carnes.normativa_espanol','designacions.identifica_ingles',
          'carnes.nombrescarne','carnes.empresacarne','carnes.designacioncarne','carnes.fechacarne','carnes.estado','carnes.fecha_reevaluacion','carnes.reevaluacion',
          'designacions.identifica','designacions.color','designacions.identifica','designacions.color','designacions.identifica_ingles')->where('carnes.id','=', $id)->where('certificados.condicion','>=', 1)->OrderBy('certificado','desc')->get();
          
          //PDF::SetProtection(array('copy','print'), '', null, 0, null);
          PDF::SetTitle('Carne - Emitido');
          PDF::SetFont('helvetica','',10);
          PDF::setCellHeightRatio(1);
          $width = 85.725;  
          $height = 53.975; 
          PDF::SetMargins(0, 0 , 0);
          PDF::AddPage('L',array($width,$height));
          PDF::SetHeaderMargin(1);
          PDF::setPrintHeader(false);
          $bMargin = PDF::getBreakMargin();
          // get current auto-page-break mode
          $auto_page_break = PDF::getAutoPageBreak();
          // disable auto-page-break
          PDF::SetAutoPageBreak(false, 0);
          //logo
          $logo ='img/Carne/ibmetro-logo-carnet-bolivia.png';
          //$logo ='img/logo-ibmetro-bolivia.png';
          PDF::Image($logo, 1, 4, 36, '', '', '', '', false, 300, '', false, false, 0);
          
          // set bacground image
          $num= Carne::findOrFail($id);
          $certifi= Certificado::findOrFail($num->idcertificado);
          $perso=Persona::findOrFail($certifi->idpersona);
          $img_file = 'img/Carne/carnet.png';
          //PDF::Image($img_file, -0.15, 0, 85.8, 54.6, '', '', '', false, 300, '', false, false, 0);
          $nuevoimg_file = 'img/Carne/carnet.png';
          PDF::Image($nuevoimg_file, -0.15, 0, 85.8, 54.6, '', '', '', false, 300, '', false, false, 0);
          $img_file2 = 'storage/'.$num->foto;
          PDF::Image($img_file2, 5.2  , 10.95, 21.4, 26.2, '', '', '', false, 300, '', false, false, 0);
          // --- Rotation --------------------------------------------
          PDF::StartTransform(); 
          $carnenum=$perso->dni;
          
          
          //$carnenum=$perso->dni.' - B-23.0'.$certifi->certificado.'.0';
          $num_caracte = strlen($perso->dni);
          PDF::Rotate(90,21,17); 
          
          PDF::SetFont ("helvetica", "", 6 , "", "default", true );
          
          PDF::Text(15, 1, $carnenum ,false,false,true,0,0,'',0,'',0);
          PDF::StopTransform();
          /*
          PDF::StartTransform(); 
          $carnenum=$perso->dni.'-'.$certifi->certificado;
          $num_caracte = strlen($perso->dni);
          if($num_caracte>8){
          PDF::Rotate(90,21, 17.5); 
          }
          else{
              PDF::Rotate(90,17.2, 14); 
          }
          PDF::SetFont ("helvetica", "", 6 , "", "default", true );
          
          PDF::Text(0, 0, $carnenum,false,false,true,0,0,'',0,'',0);
          PDF::StopTransform();
          */
          $qr='qrcodes/'.$certifi->qr;
          PDF::ImageSVG($qr, 74, 7, 10, 10, '', '', '', false, 300, '', false, false, 0);
          // restore auto-page-break status
          PDF::SetAutoPageBreak(true, 1);
          $hola=0;
          PDF::writeHTML(view('pdf.carneCpdf',['carnes' => $carnes,'data' => $data,'hola'=>$hola])->render(),true, false, false, false, '');
         
          //Page2
          PDF::AddPage('L',array($width,$height));
            $bMargin = PDF::getBreakMargin();
        // get current auto-page-break mode
            $auto_page_break = PDF::getAutoPageBreak();
        // disable auto-page-break

        PDF::SetAutoPageBreak(false, 0);
        // set bacground image
        $color= Designacion::findOrFail($num->iddesignacion);
        
        $img_file3 ='img/Carne/carnet2.png';
        //PDF::Image($img_file3, -0.15, 0, 88, 54.6, '', '', '', false, 300, '', false, false, 0);
        $nuevoimg_file3 ='img/Carne/carnet2.png';
        PDF::Image($nuevoimg_file3, -0.15, 0, 88, 54.6, '', '', '', false, 300, '', false, false, 0);
        //Empresa Posiscisión vertical
        $hola=0;
        // restore auto-page-break status
        PDF::SetAutoPageBreak(true, 1);
        PDF::writeHTML(view('pdf.carneC2pdf',['carnes' => $carnes,'data' => $data,'hola'=>$hola])->render(),true, true, true, true, '');         
        $designacion=Designacion::findOrFail($certifi->iddesignacion );
        $filename = $designacion->identifica_ingles.'-'.date("Y", strtotime($certifi->fecha_emision7)).'-0'.$certifi->certificado.' '.$certifi->persona.'.pdf';
        
        //$filename = 'P-'.$certifi->certificado.' '.$certifi->persona.' Carne.pdf';

        PDF::Output($filename, 'I');
      }

      public function carneEmisionPdf1(Request $request,$id){
        //if(!$request->ajax()) return redirect('/');
        $qrcode = new Generator;
        $data = $qrcode->format('svg')->size(399)->color(40,40,40)->generate('Make me a QrCode!','../public/qrcodes/qrcode.svg');
        $carnes = Carne::join('users','carnes.idusuario','=','users.id')->
          join('designacions','carnes.iddesignacion','=','designacions.id')->
          join('certificados','carnes.idcertificado','=','certificados.id')->
          join('tipo_certificados','certificados.idtipo_certificado','=','tipo_certificados.id')->
          join('personas','certificados.idpersona','=','personas.id')->
          select('users.nombre as usuario_nombre','users.apellido as usuario_apellido',
          'certificados.id','certificados.pdsi','personas.dni','certificados.empresa','certificados.certificado',
          'certificados.persona','certificados.empresa','certificados.certificado','certificados.equipo','certificados.cond_equipo',
          'tipo_certificados.id as idtipo_certificado','tipo_certificados.nombre as tipo_certificados',
          'certificados.level','certificados.normativa','certificados.qr','certificados.condicion','certificados.fecha_emision7',
          'certificados.fecha_revalidacion','certificados.fecha_expiracion',
          'carnes.foto','carnes.designacion_espanol','carnes.equipo_espanol','carnes.normativa_espanol',
          'carnes.nombrescarne','carnes.empresacarne','carnes.designacioncarne','carnes.fechacarne','carnes.estado','carnes.fecha_reevaluacion','carnes.reevaluacion',
          'designacions.identifica','designacions.color','designacions.identifica','designacions.color')->where('carnes.id','=', $id)->where('certificados.condicion','>=', 1)->OrderBy('certificado','desc')->get();
          
          //PDF::SetProtection(array('copy','print'), '', null, 0, null);
          PDF::SetTitle('Carne - Reevalidación');
          PDF::SetFont('helvetica','',10);
          PDF::setCellHeightRatio(1);
          $width = 85.725;  
          $height = 53.975; 
          PDF::SetMargins(0, 0 , 0);
          PDF::AddPage('L',array($width,$height));
          PDF::SetHeaderMargin(1);
          PDF::setPrintHeader(false);
          $bMargin = PDF::getBreakMargin();
          // get current auto-page-break mode
          $auto_page_break = PDF::getAutoPageBreak();
          // disable auto-page-break
          PDF::SetAutoPageBreak(false, 0);
          
          // set bacground image
          $num= Carne::findOrFail($id);
          $certifi= Certificado::findOrFail($num->idcertificado);
          $perso=Persona::findOrFail($certifi->idpersona);
          $img_file = 'img/Carne/carne-frontal.jpg';
          PDF::Image($img_file, -0.15, 0, 85.8, 54.6, '', '', '', false, 300, '', false, false, 0);
          $img_file2 = 'storage/'.$num->foto;
          PDF::Image($img_file2, 3.9, 12.4, 20.3, 25.8, '', '', '', false, 300, '', false, false, 0);
          // --- Rotation --------------------------------------------
          PDF::StartTransform();          
          PDF::Rotate(90,17.2, 14); 
          PDF::SetFont ("helvetica", "", 6 , "", "default", true );
          $carnenum=$perso->dni.'-'.$certifi->certificado;
          PDF::Text(0, 0, $carnenum,false,false,true,0,0,'',0,'',0);
          PDF::StopTransform();
          $qr='qrcodes/'.$certifi->qr;
          PDF::ImageSVG($qr, 75, 8, 9, 9, '', '', '', false, 300, '', false, false, 0);
          // restore auto-page-break status
          PDF::SetAutoPageBreak(true, 1);
          $hola=1;
          PDF::writeHTML(view('pdf.carnepdf',['carnes' => $carnes,'data' => $data,'hola'=>$hola])->render(),true, false, false, false, '');
         
          //Page2
          PDF::AddPage('L',array($width,$height));
            $bMargin = PDF::getBreakMargin();
        // get current auto-page-break mode
            $auto_page_break = PDF::getAutoPageBreak();
        // disable auto-page-break

        PDF::SetAutoPageBreak(false, 0);
        // set bacground image
        $color= Designacion::findOrFail($num->iddesignacion);
        switch($color->color){
          case 1: $img_file3 ='img/Carne/Operador_grua.png';
            break;
          case 2: $img_file3 ='img/Carne/verde_claro.png';
            break;
          case 3: $img_file3 ='img/Carne/Negro.png';
            break;
          case 4: $img_file3 ='img/Carne/morado.png';
            break;
          case 5: $img_file3 ='img/Carne/anaranjado.png';
            break;
          case 6: $img_file3 ='img/Carne/amarilla.png';
            break;
          case 7: $img_file3 ='img/Carne/blanco.png';
          break; 
        }
        PDF::Image($img_file3, -0.15, 0, 85.8, 54.6, '', '', '', false, 300, '', false, false, 0);
        //Empresa Posiscisión vertical
        $hola=1;
        // restore auto-page-break status
        PDF::SetAutoPageBreak(true, 1);
        PDF::writeHTML(view('pdf.carne2pdf',['carnes' => $carnes,'data' => $data,'hola'=>$hola])->render(),true, true, true, true, '');         
        

        $filename = 'P-'.$certifi->certificado.' '.$certifi->persona.' Carne.pdf';

        PDF::Output($filename, 'I');
      }

      public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $carne = Carne::findOrFail($request->id);
        $carne->fecha_reevaluacion=$request->fecha_revalido;
        $carne->estado='4';
        $carne->save();
    }
    public function emiCard(Request $request){
     //if(!$request->ajax()) return redirect('/');
      //Carné
    $carne = Carne::findOrFail($request->idcarne);
    $carne->idusuario  = Auth::user()->id;
    $carne->iddesignacion=$request->iddesignacion;
    $carne->idcertificado=$request->idcertificado;
    $designacion = Designacion::findOrFail($request->iddesignacion);
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
    
    $fechaVenceC=date("d/m/Y", strtotime($request->fecha_expiracion));
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
        //$fechaRevalidC=date("d/m/Y", strtotime($fec_reevaluacion));
      }
      else {
        $carne->reevaluacion=0;
      }
      $carne->fechacarne="<font style=\"font-size:8pt;\">";
    }
    $carne->nombrescarne="<font style=\"font-size:8pt;\">$request->persona</font>";
    $carne->empresacarne="<font style=\"font-size:8pt;\">$request->empresa</font>";
    $desig='';
    switch($request->tipo_certificado_id){
      case 5: $desig='Operador';
      
          break;
      case 6: $desig='Aparejador';
          break;
      case 7: $desig='Supervisor';

          break;
      case 8: $desig='Inspector';
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
    else{
      $nivelcarne='';
    }
    if($request->cond_equipo==0){
      if($request->tipo_certificado_id==8 || $request->tipo_certificado_id==7){
      $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$designacion->designacion_ingles 
</font><font style=\"font-size:8pt;\"><br/> INSPECTOR 
</font>";}
        else{
       $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$desig de $designacion->designacion_espanol 
</font><br><br>
<font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";
        }
      }
      else{
      $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$desig de $designacion->designacion_espanol: 
<br/>$equipocarne</font><br><br>
<font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";}
    
    
    $carne->save();

    }
    public function actualizarCarne(Request $request){
      if(!$request->ajax()) return redirect('/');
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
        case 8: $desig='Inspector';
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
      else{
        $nivelcarne='';
      }
      if($request->cond_equipo==0){
        if($request->tipo_certificado_id==8 || $request->tipo_certificado_id==7){
        $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$designacion->designacion_ingles 
  </font><font style=\"font-size:8pt;\"><br/> INSPECTOR 
  </font>";}
          else{
         $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$desig de $designacion->designacion_espanol 
  </font><br><br>
  <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";
          }
        }
        else{
        $carne->designacioncarne="<br/><font style=\"font-size:8pt;\"><br/>$desig de $designacion->designacion_espanol: 
  <br/>$equipocarne</font><br><br>
  <font style=\"font-size:6pt;\"><br/>$nivelcarne</font>";}
      
      
      $carne->save();

    }
}
