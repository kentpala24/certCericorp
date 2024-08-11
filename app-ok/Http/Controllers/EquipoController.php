<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Equipo;
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
        if($pdsi=='' && $empresa=='' && $modelo=='' && $numero=='' && $equipo=='' && $serie==''){
            $equipos = Equipo::select('id','idusuario','codigo_certificado','codigo_informe','fechaIspeccion',
            'fechaRecomendada','fechaEmision','tipoEquipo','marca','modeloEquipo','serie','ruc','cliente','pdsi','otro',
            'estado','capacidad','qr')->OrderBy('id','desc')->paginate(50);
        }
        else{
            $equipos= Equipo::select('id','idusuario','codigo_certificado','codigo_informe','fechaIspeccion',
            'fechaRecomendada','fechaEmision','tipoEquipo','marca','modeloEquipo','serie','ruc','cliente','pdsi','otro',
            'estado','capacidad','capacidad','qr')->where('pdsi', 'like', '%'.$pdsi.'%')->where('cliente', 'like', '%'.$empresa.'%')
            ->where('modeloEquipo', 'like', '%'.$modelo.'%')->where('codigo_certificado', 'like', '%'.$numero.'%')
            ->where('tipoEquipo', 'like', '%'.$equipo.'%')->where('serie', 'like', '%'.$serie.'%')
            ->orderBy('id','desc')->OrderBy('id','desc')->paginate(50);
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

    public function store(Request $request)
    {   
        $equipos = new Equipo();
        $equipos->idusuario = Auth::user()->id;
        $equipos->codigo_certificado=$request->codigo_certificado;
        $equipos->codigo_informe=$request->codigo_informe;
        $equipos->fechaIspeccion=$request->fechaIspeccion;
        $equipos->fechaRecomendada=$request->fechaRecomendada;
        $equipos->fechaEmision=$request->fechaEmision;
        $equipos->tipoEquipo=$request->tipoEquipo;
        $equipos->marca=$request->marca;
        $equipos->modeloEquipo=$request->modeloEquipo;
        $equipos->serie=$request->serie;
        $equipos->capacidad=$request->capacidad;
        $equipos->ruc=$request->ruc;
        $equipos->cliente=$request->cliente;
        $equipos->pdsi=$request->pdsi;
        // Generar Código QR
        $qrcode = new Generator;
        $nombre=time().'.svg';
        $qr='https://certificado.cicbla.com/equipment?ruc='.$request->ruc.'&serie='.$request->serie.'&pdsi='.$request->pdsi;
        $qrcode->format('svg')->size(120)->generate($qr,'../public/qrcodes/equipo/'.$nombre);
        $equipos->qr=$nombre;
        $equipos->otro=$request->otro;
        $equipos->estado=1;
        $equipos->save();

    }

    public function update(Request $request)
    {        
      $equipos = Equipo::findOrFail($request->id);
      $equipos->idusuario = Auth::user()->id;
      $equipos->codigo_certificado=$request->codigo_certificado;
      $equipos->codigo_informe=$request->codigo_informe;
      $equipos->fechaIspeccion=$request->fechaIspeccion;
      $equipos->fechaRecomendada=$request->fechaRecomendada;
      $equipos->fechaEmision=$request->fechaEmision;
      $equipos->tipoEquipo=$request->tipoEquipo;
      $equipos->marca=$request->marca;
      $equipos->modeloEquipo=$request->modeloEquipo;
      // Generar Código QR
      if($equipos->serie!=$request->serie || $equipos->ruc!=$request->ruc || $equipos->pdsi!=$request->pdsi){
        $qrcode = new Generator;
        $nombre=time().$request->modeloEquipo.'.svg';
        $qr='https://certificado.cicbla.com/equipment?ruc='.$request->ruc.'&serie='.$request->serie.'&pdsi='.$request->pdsi;
        $qrcode->format('svg')->size(120)->generate($qr,'../public/qrcodes/equipo/'.$nombre);
        $equipos->qr=$nombre;
      }
      else{
      }
      $equipos->serie=$request->serie;
      $equipos->capacidad=$request->capacidad;
      $equipos->ruc=$request->ruc;
      $equipos->cliente=$request->cliente;
      $equipos->pdsi=$request->pdsi;
      
      
      $equipos->otro=$request->otro;
      $equipos->estado=1;
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
        $equipos->estado = '1';
        $equipos->save();
    }
    
}
