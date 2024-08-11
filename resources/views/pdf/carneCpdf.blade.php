<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Digital</title>
</head>
<body>
<style>
div.texto-vertical-2{
    writing-mode: vertical-lr;
    transform: rotate(180deg);
}
</style>
<table width="100%" height="100%"> 
@foreach ($carnes as $c)
            <tr>
                <td rowspan="5" style="width:30px; font-size:8pt"></td>
                <td colspan="3" style="height: 27.5px;"></td>
            </tr>
            <tr>
                <td style="width:42px; font-size:8pt"></td>
                @if($hola==4)
                <td colspan="2" style="font-size:8pt; width:160px; height:17px; text-align:center"><strong></strong></td>
                @else
                    @if($c->idtipo_certificado==8 || $c->idtipo_certificado==9)
                    <td colspan="2" style="font-size:8pt; width:160px; height:15px; text-align:center"><strong> CERTIFICATION # P-{{$c->certificado}} <br>TECHNICAL COMPETENCE</strong> <br/></td>
                    @else
                    <td colspan="2" style="font-size:6.2pt; width:190px; height:13.5px; text-align:center"><strong>: {{$c->identifica_ingles}}-{{date("Y", strtotime($c->fecha_emision7))}}-0{{$c->certificado}}</strong></td>
                    @endif
                @endif
                
            </tr>
            <tr>
                <td style="width:40px font-size:8pt"></td>
                @if($c->idtipo_certificado==8 || $c->idtipo_certificado==9)
                <td style="font-size:8pt; width:38px; height:17px">Issued To:</td>
                @else
                <td style="font-size:8pt; width:38px; height:13px"></td>
                @endif
                <td style="font-size:8pt; width:132; text-align:center">{!! str_replace("ñ", "Ñ", strtoupper($c->nombrescarne)) !!}</td>
            </tr>
            @if($c->idtipo_certificado==8 || $c->idtipo_certificado==9)
            <tr>
                <td colspan="3" style="width:40px; height:0px;font-size:0pt"></td>
            </tr>
            @else
            <tr>
                <td style="width:40px; font-size:8pt"></td>
                <td style="font-size:8pt; width:35px"></td>
                <td style="width:135; font-size:8pt; text-align:center; height:16px">{!! str_replace("ñ", "Ñ", strtoupper($c->empresacarne)) !!}</td>
            </tr>
            @endif
            <tr>
                <td style="width:40px; font-size:2pt"></td>
                @if($c->idtipo_certificado==8 || $c->idtipo_certificado==9)
                <td colspan="2" style="font-size:5pt; width:170px; text-align:center; height:16px"> <br/> <br/>The person named has successfully completed the <br>classroom and hands-on training for:</td>
                @else
                <td colspan="2" style="font-size:2.5pt; width:170px; text-align:center">&nbsp;</td>
                @endif
            </tr>
            <tr>
                <td colspan="1" style="width:8px"></td>
                <td colspan="1" style="width:70px"><br><br><br><br>
                    
                    <table>
            @if($hola==0)
                @if($c->reevaluacion == 0)
                    @if($c->idtipo_certificado==8 || $c->idtipo_certificado==7)
                    @if($c->idtipo_certificado==8)
                    <tr>
                        <td style="font-size:6pt;width:28px ">DATE: </td>
                        <td style="font-size:6pt;width:45px"> {{date("m/d/Y", strtotime($c->fecha_emision7))}} </td>
                    </tr>
                    <tr>
                        <td style="font-size:6pt">EXPIRES: </td>
                        <td style="font-size:6pt"> {{date("m/d/Y", strtotime($c->fecha_expiracion))}}</td>
                    </tr>
                    @else
                    <tr>
                        <td style="font-size:6pt;width:36px ">EMITIDO: </td>
                        <td style="font-size:6pt;width:45px"> {{date("d/m/Y", strtotime($c->fecha_emision7))}} </td>
                    </tr>
                    <tr>
                        <td style="font-size:6pt">REVALIDAR: </td>
                        <td style="font-size:6pt"> {{date("d/m/Y", strtotime($c->fecha_revalidacion))}}</td>
                    </tr>
                    @endif
                    
                    
                    @else
                    @if($c->estado==0 || $c->estado==2)
                    <tr>
                        <td style="font-size:6pt;width:28px ">EMITIDO: </td>
                        <td style="font-size:6pt;width:45px"> {{date("d/m/Y", strtotime($c->fecha_emision7))}} </td>
                    </tr>
                    <tr>
                        <td style="font-size:6pt">VENCE: </td>
                        <td style="font-size:6pt"> {{date("d/m/Y", strtotime($c->fecha_expiracion))}}</td>
                    </tr>
                    @endif
                    @endif
                @elseif($c->reevaluacion == 1)
                     @if($c->idtipo_certificado==8 || $c->idtipo_certificado==7)
                    <tr>
                        <td style="font-size:6pt;width:28px ">DATE: </td>
                        <td style="font-size:6pt;width:45px"> {{date("m/d/Y", strtotime($c->fecha_emision7))}} </td>
                    </tr>
                    <tr>
                        <td style="font-size:6pt">EXPIRES: </td>
                        <td style="font-size:6pt"> {{date("m/d/Y", strtotime($c->fecha_expiracion))}}</td>
                    </tr>
                    @else
                    <tr>
                        <td style="font-size:6pt;width:36px ">EMITIDO: </td>
                        <td style="font-size:6pt;width:37px"> {{date("d/m/Y", strtotime($c->fecha_emision7))}} </td>
                    </tr>
                    <tr>
                        <td style="font-size:6pt">REVALIDAR: </td>
                        <td style="font-size:6pt"> {{date("d/m/Y", strtotime($c->fecha_revalidacion))}}</td>
                    </tr>
                    @endif
                @endif
            @elseif($hola==1)
                    <tr>
                        <td style="font-size:6pt;width:33px ">REVALIDÓ: </td>
                        <td style="font-size:6pt;width:37px"> {{date("d/m/Y", strtotime($c->fecha_reevaluacion))}} </td>
                    </tr>
                    <tr>
                        <td style="font-size:6pt">VENCE: </td>
                        <td style="font-size:6pt"> {{date("d/m/Y", strtotime($c->fecha_expiracion))}}</td>
                    </tr>
            @elseif($hola==4)
                @if($c->revalidacion == 1)
                    <tr>
                        <td style="font-size:6pt;width:33px ">REVALIDÓ: </td>
                        <td style="font-size:6pt;width:37px"> {{date("d/m/Y", strtotime($c->fecha_reevaluacion))}} </td>
                    </tr>
                    <tr>
                        <td style="font-size:6pt">VENCE: </td>
                        <td style="font-size:6pt"> {{date("d/m/Y", strtotime($c->fecha_expiracion))}}</td>
                    </tr>
                @elseif($c->revalidacion == 0)
                    @if($c->nivel=='Basic Level')
                    <tr>
                        <td style="font-size:6pt;width:28px ">EMITIDO: </td>
                        <td style="font-size:6pt;width:45px"> {{date("d/m/Y", strtotime($c->fecha_emision7))}} </td>
                    </tr>
                    <tr>
                        <td style="font-size:6pt">VENCE: </td>
                        <td style="font-size:6pt"> {{date("d/m/Y", strtotime($c->fecha_expiracion))}}</td>
                    </tr>
                    
                    @else
                    <tr>
                        <td style="font-size:6pt;width:36px ">EMITIDO: </td>
                        <td style="font-size:6pt;width:37px"> {{date("d/m/Y", strtotime($c->fecha_emision7))}} </td>
                    </tr>
                    <tr>
                        <td style="font-size:6pt">REVALIDAR: </td>
                        <td style="font-size:6pt"> {{date("d/m/Y", strtotime($c->fecha_revalidacion))}}</td>
                    </tr>
                    @endif

                @endif

            @endif
            
                    </table>
                </td>
                
                <td colspan="2" style="font-size:8pt; width:165px; text-align:center; height:45px"><br><br> {!! $c->designacioncarne !!}</td>
            </tr>
        
        
       
@endforeach
</table>

    
    
    
    
    


</body>
</html>