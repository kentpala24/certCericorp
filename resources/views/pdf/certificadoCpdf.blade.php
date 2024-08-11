<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado Digital</title>
</head>
<body>
<div id="background">
<style>
        body{
            font-family:Arial !important;
        }
        H1.contenido {display:inline;}
        H1.contenido {display:inline;}
        H4.contenido {
            display:inline; }
        H5.contenido {
            display:inline; }
        H6.contenido {
            display:inline; }
        H3.contenido {
            display:inline; }
        table {
            border-collapse: collapse;
            font-family:Arial !important;
        }
        b{
            font-size:9.5pt;
        }
        img{
            float: right;
            padding-right: 80px;
        }
        td.certi{
            text-align: center;
        }
        td.certifi{
            text-align: center;
            padding-top: 6px;
            
        }
        .lineaVerde{
            height:17px;
            font-size:9.5pt;
            border-bottom: 2px solid #008000;"
        }
        .lineaVerde2{
            height:20px;
            font-size:9.5pt;
            border-bottom: 2px solid #008000;"
        }
        .lineaVerde2SinBorde{
            height:20px;
            font-size:9.5pt;
        }
        .lineaVerde3{
            height:25px;
            font-size:9.5pt;
            border-bottom: 2px solid #008000;"
        }
        .saltoLineaM{
            font-size:5pt;
        }
        .saltoLineaM2{
            font-size:0.8pt;
        }
        .lineaVerdeSinAltura{
            font-size:9.5pt;
            border-bottom: 2px solid #008000;"
        }
        .tamaSalto{
            font-size:0.8px;
        }
        .tamaSaltoS56{
            font-size:3px;
        }
        td.anchoLinea{
            width:85px;
        }
        td.anchoCabe{
            width:470px;
        }
        td.anchoDetaI{
            width:185px;
            
        }
        td.anchoDetaD{
            width:275px;
            font-size:9.5pt;
        }
        td.anchoDetaD3{
            width:270px;
            font-size:9.5pt;
        }
        td.anchoDetaD2{
            width:280px;
            font-size:9.5pt;
        }
        td.anchoDetaD4{
            width:270px;
            font-size:9.5pt;
        }
        table{
            position: relative; /* Asegura que el contenido esté por delante de la imagen */
            z-index: 1000;
        }/*
        td,th,tr{
            border: 1px solid #000;
        }*/
        @page {margin:1px;}
        
    </style>

    <table width="100%" height="100%">
    @foreach ($certificados as $c)
    <thead>
        
    </thead>
    <tbody>
    <tr>
        <td colspan="11"></td>
        <td colspan="4" style="height:68px"><p>&nbsp;</p><p>&nbsp;</p><br>&nbsp;</td>
        <td colspan="1"></td>
    </tr>
    <tr>
        <td colspan="9"></td>
        <td colspan="7" style="height:18px">Certificado N°: CE-ABXXXX-XXX/ABC00{!! strtoupper($c->certificado) !!}</td>
        
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="10" style="height:17px"><b style="font-size:15pt;">CERTIFICADO DE EVALUACIÓN DE PERSONAL</b><br></td>
        <td colspan="2"></td>
    </tr>
    
    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde anchoCabe"><b style="font-family:Arial !important;"> 1.   INFORMACIÓN GENERAL:  </b>
        </td>
        <td colspan="1"><b></b></td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI" style="margin: 20px !important;"><b class="tamaSalto">&nbsp;<br></b><b>CLIENTE </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD2" style="margin: 20px !important;"><b class="tamaSalto">&nbsp;<br></b>{!! strtoupper($c->empresa) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>LUGAR DE EVALUACIÓN </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSalto">&nbsp;<br></b>{!! strtoupper($c->lugar) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>FECHA DE EVALUACIÓN </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="9" class="anchoDetaD3"><b class="tamaSalto">&nbsp;<br></b>{{ date("d/m/Y", strtotime($c->fecha_emision))}}</td>
    </tr>
    <tr>
        <td colspan="1" class="anchoLinea"></td>
        <td colspan="1" style="width:5px" class="lineaVerdeSinAltura"></td>
        <td colspan="5" class="anchoDetaI lineaVerdeSinAltura"><b class="tamaSalto">&nbsp;<br></b><b>FECHA DE EMISIÓN CERTIFICADO </b></td>
        <td colspan="1" style="width:10px" class="lineaVerdeSinAltura">:</td>
        <td colspan="7" class="anchoDetaD4" style="border-bottom: 2px solid #008000;"><b class="tamaSalto">&nbsp;<br></b>{{ date("d/m/Y", strtotime($c->fecha_emision7))}}<b class="tamaSalto"><br>&nbsp;</b></td>
    </tr>

    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde2 anchoCabe"><b class="saltoLineaM">&nbsp;<br></b><b>2.   DATOS DEL PERSONAL EVALUADO: </b></td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>APELLIDOS </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSalto">&nbsp;<br></b>{!! strtoupper($c->apellido) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>NOMBRES </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSalto">&nbsp;<br></b>{!! strtoupper($c->nombre) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>DNI / PASAPORTE </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSalto">&nbsp;<br></b>{!! strtoupper($c->dni) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>CALIFICACIÓN </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSalto">&nbsp;<br></b>{!! mb_strtoupper($c->identifica, 'UTF-8') !!}</td>
    </tr>
    <tr>
        <td colspan="1" class="anchoLinea"></td>
        <td colspan="1" style="width:5px" class="lineaVerdeSinAltura"></td>
        <td colspan="5" class="anchoDetaI lineaVerdeSinAltura"><b class="tamaSalto">&nbsp;<br></b><b>FECHA ÚLTIMO CERTIFICADO </b></td>
        <td colspan="1" style="width:10px" class="lineaVerdeSinAltura" >:</td>
        <td colspan="8"  class="anchoDetaD4" style="border-bottom: 2px solid #008000;"><b class="tamaSalto">&nbsp;<br></b>@if($c->fecha_emision2 === null || $c->fecha_emision2 === '')
                    N/A 
                @else
                {{ date("d/m/Y", strtotime($c->fecha_emision2))}}
                @endif
                <b class="tamaSalto"><br>&nbsp;</b>
            </td>
    </tr>

    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde2 anchoCabe"><b class="saltoLineaM">&nbsp;<br></b><b>3.   REFERENCIA NORMATIVA: </b></td>
    </tr>
    <tr>
        <td colspan="1" class="anchoLinea"></td>
        <td colspan="1" style="width:10px" class="lineaVerdeSinAltura"></td>
        <td colspan="12"  style="width:460px;"  class="lineaVerdeSinAltura"><b class="saltoLineaM">&nbsp;<br></b>- {!! strtoupper($c->normativa_espanol) !!}<b class="saltoLineaM">&nbsp;<br></b></td>
        <td colspan="2"></td>
    </tr>

    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde2 anchoCabe"><b class="saltoLineaM">&nbsp;<br></b><b>4.   DATOS DE LA EVALUACIÓN TEÓRICO Y PRÁCTICOS: </b></td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>RESULTADO </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSalto">&nbsp;<br></b>{!! strtoupper($c->resultado) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>PUNTAJE FINAL EN % </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSalto">&nbsp;<br></b>{!! strtoupper($c->puntaje) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b style="font-size:9.5pt;">CAPACIDAD DE EQUIPO UTILIZADO </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSalto">&nbsp;<br></b>{!! strtoupper($c->capacidad) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>TIPO DE EQUIPO </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSalto">&nbsp;<br></b>{!! mb_strtoupper($c->horas, 'UTF-8') !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:90px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>MARCA</b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSalto">&nbsp;<br></b>{!! strtoupper($c->equipo) !!}</td>
    </tr>
    <tr>
        <td colspan="1" class="anchoLinea"></td>
        <td colspan="1" style="width:5px" class="lineaVerdeSinAltura"></td>    
        <td colspan="5" class="anchoDetaI lineaVerdeSinAltura"><b class="tamaSalto">&nbsp;<br></b><b>MODELO </b></td>
        <td colspan="1" style="width:10px" class="lineaVerdeSinAltura">:</td>
        <td colspan="7"  class="anchoDetaD4" style="border-bottom: 2px solid #008000;"><b class="tamaSalto">&nbsp;<br></b>{!! strtoupper($c->modelo) !!}<b class="tamaSalto"><br>&nbsp;</b></td>
    
    </tr>

    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde2 anchoCabe"><b class="saltoLineaM">&nbsp;<br></b><b>5.   CONCLUSIONES: </b></td>
    </tr>
    <tr>
        <td colspan="1" class="anchoLinea"></td>
        <td colspan="1" style="width:10px" class="lineaVerdeSinAltura"></td> 
        <td colspan="12" style="width:460px;" class="lineaVerdeSinAltura"><font class="tamaSaltoS56"><br/><font style="font-size:9.5pt; text-align: justify;">CERICORP S.A.C, certifica que ha realizado la evaluación Teórica – Práctico obteniendo resultado satisfactorio del personal para su calificación definido en el Ítem 2.
La evaluación cumple con los requisitos normativos y/o procedimientos del cliente, descrito en el ítem 3.
La información contenida en este certificado es un resumen de lo declarado en el Informe de evaluación Nro.  {!! strtoupper($c->informes) !!} En el cual, refleja todos los valores, observaciones y los resultados obtenidos, en el lugar y fecha definidos en este Certificado.
    </font><br/></font></td>
    <td colspan="2"></td>
    </tr>
    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde2 anchoCabe"><b class="saltoLineaM">&nbsp;<br></b><b>6.   VALIDEZ: </b></td>
    </tr>
    <tr>
        <td colspan="1" class="anchoLinea"></td>
        <td colspan="1" style="width:10px" class="lineaVerdeSinAltura"></td> 
        <td colspan="12" style="width:460px" class="lineaVerdeSinAltura"><font class="tamaSaltoS56"><br><font style="font-size:9.5pt; text-align: justify;">El presente certificado tiene vigencia de @if($c->level=="Basic Level")12 (Doce)@else 24 (Veinticuatro)@endif Meses desde la fecha de emisión.  
Pierde validez en caso, si el personal evaluado no cuenta con el examen de actitud física. Este certificado podrá ser suspendido por parte del responsable de seguridad, en caso si el personal descrito en el Item 2. Incumpla los procedimientos de seguridad en las operaciones de izaje, En consecuencia, el personal debe capacitarse, para su revaluación. 
    </font><br/></font></td>
    <td colspan="2" ></td>
    </tr>
    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde2SinBorde anchoCabe"><b class="saltoLineaM">&nbsp;<br></b><b>7.   APROBADO POR: </b></td>
    </tr>
    <tr>
        <td colspan="2" style="height:{{$c->separacion}}px"></td>
    </tr>
    <tr>
        <td colspan="2" style="width:115px;"></td>
        <td colspan="10" style="width:165px;border-top: 1px solid #000;"><b style="font-size:8pt; text-align: center;"> {!! strtoupper($c->cabecera) !!}</b></td>
        <td colspan="4"><b></b></td>
    </tr>
    
    
    </tbody>
    @endforeach
    </table>

    
    
    
    
    


</div>
</body>
</html>