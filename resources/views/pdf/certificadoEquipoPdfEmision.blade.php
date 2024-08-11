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
            font-size:0.1px;
        }
        .tamaSaltoD{
            font-size:1.8px;
        }
        .tamaSaltoS56{
            font-size:2.3px;
        }
        td.anchoLinea{
            width:90px;
        }
        td.anchoCabe{
            width:470px;
        }
        td.anchoDetaI{
            width:201px;
            
        }
        td.anchoDetaD{
            width:259px;
            font-size:9.5pt;
        }
        td.anchoDetaD3{
            width:254px;
            font-size:9.5pt;
        }
        td.anchoDetaD2{
            width:264px;
            font-size:9.5pt;
        }
        td.anchoDetaD4{
            width:254px;
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
        <td colspan="7" style="height:18px">Certificado N°: {!! strtoupper(str_replace('/', '|', $c->certificado)) !!}</td>
        
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="10" style="height:17px; text-align:center; vertical-align:middle;"><b style="font-size:13pt;">CERTIFICADO DE {!! mb_strtoupper($c->tipo_certificado, 'UTF-8') !!}</b><br></td>
        <td colspan="2"></td>
    </tr>
    
    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde anchoCabe"><b style="font-family:Arial !important;"> 1.   INFORMACIÓN GENERAL:  </b>
        </td>
        <td colspan="1"><b></b></td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI" style="margin: 20px !important;"><b class="tamaSalto">&nbsp;<br></b><b>CLIENTE </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD2" style="margin: 20px !important;"><b class="tamaSaltoD">&nbsp;<br></b>{!! strtoupper($c->cliente) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>LUGAR DE INSPECCIÓN </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSaltoD">&nbsp;<br></b>{!! strtoupper($c->lugar) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>FECHA DE INSPECCIÓN </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="9" class="anchoDetaD3"><b class="tamaSaltoD">&nbsp;<br></b>{!! strtoupper($c->fecha_inspeccion2)!!}</td>
    </tr>
    <tr>
        <td colspan="1" class="anchoLinea"></td>
        <td colspan="1" style="width:5px" class="lineaVerdeSinAltura"></td>
        <td colspan="5" class="anchoDetaI lineaVerdeSinAltura"><b class="tamaSalto">&nbsp;<br></b><b>FECHA DE EMISIÓN CERTIFICADO </b></td>
        <td colspan="1" style="width:10px" class="lineaVerdeSinAltura">:</td>
        <td colspan="7" class="anchoDetaD4" style="border-bottom: 2px solid #008000;"><b class="tamaSaltoD">&nbsp;<br></b>{{ date("d/m/Y", strtotime($c->fecha_emision))}}<b class="tamaSalto"><br>&nbsp;</b></td>
    </tr>

    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde2 anchoCabe"><b class="saltoLineaM">&nbsp;<br></b><b>2.   IDENTIFICACIÓN DEL EQUIPO: </b></td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>TIPO DE EQUIPO </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD2" style="margin: 20px !important;"><b class="tamaSaltoD">&nbsp;<br></b>{!! mb_strtoupper($c->tipo_equipo, 'UTF-8') !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>PROPIETARIO </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSaltoD">&nbsp;<br></b>{!! strtoupper($c->propietario) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>MARCA </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSaltoD">&nbsp;<br></b>{!! strtoupper($c->marca) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>MODELO </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSaltoD">&nbsp;<br></b>{!! mb_strtoupper($c->modelo, 'UTF-8') !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>NUMERO DE SERIE </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSaltoD">&nbsp;<br></b>{!! mb_strtoupper($c->serie, 'UTF-8') !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>CAPACIDAD MÁXIMA NOMINAL</b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSaltoD">&nbsp;<br></b>{!! mb_strtoupper($c->capacidad, 'UTF-8') !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>CÓDIGO DE INDENTIFICACIÓN INTERNO </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSaltoD">&nbsp;<br></b>{!! mb_strtoupper($c->cod_interno, 'UTF-8') !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>FABRICANTE Y PROCEDENCIA </b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD3"><b class="tamaSaltoD">&nbsp;<br></b>{!! mb_strtoupper($c->fabricante, 'UTF-8') !!}</td>
    </tr>
    @php($indi=0)
    @if($c->campo1 === null || $c->campo1 === '')
        
    @else
        @php($indi=1)
    @endif
    @if($c->campo2 === null || $c->campo2 === '')
        
    @else
        @php($indi=2)
    @endif
    <tr>
        @if($indi == 0)
        <td colspan="1" class="anchoLinea"></td>
        @endif
        <td colspan="{{ $indi == 0 ? 1 : 2 }}" style="{{ $indi == 0 ? 'width:5px' : 'width:95px' }}"  class="{{ $indi == 0 ? 'lineaVerdeSinAltura' : '' }}"></td>
        <td colspan="5" class="anchoDetaI {{ $indi == 0 ? 'lineaVerdeSinAltura' : '' }}"><b class="tamaSalto">&nbsp;<br></b><b>AÑO DE CONSTRUCCIÓN </b></td>
        <td colspan="1" style="width:10px" class="{{ $indi == 0 ? 'lineaVerdeSinAltura' : '' }}">:</td>
        <td colspan="8" style="{{ $indi == 0 ? 'border-bottom: 2px solid #008000' : '' }}" class=" {{ $indi == 0 ? 'anchoDetaD4' : 'anchoDetaD3' }}"><b class="tamaSaltoD">&nbsp;<br></b>{!! mb_strtoupper($c->anio, 'UTF-8') !!}@if($indi == 0)<b class="tamaSalto"><br>&nbsp;</b>@endif</td>
    </tr>
    
    @if($c->campo1 === null || $c->campo1 === '')
        
    @else
    <tr>
        @if($indi == 1)
        <td colspan="1" class="anchoLinea"></td>
        @endif
        <td colspan="{{ $indi == 1 ? 1 : 2 }}" style="{{ $indi == 1 ? 'width:5px' : 'width:95px' }}"  class="{{ $indi == 1 ? 'lineaVerdeSinAltura' : '' }}"></td>
        <td colspan="5" class="anchoDetaI {{ $indi == 1 ? 'lineaVerdeSinAltura' : '' }}"><b class="tamaSalto">&nbsp;<br></b><b>{!! mb_strtoupper($c->campo1, 'UTF-8') !!}</b></td>
        <td colspan="1" style="width:10px" class="{{ $indi == 1 ? 'lineaVerdeSinAltura' : '' }}">:</td>
        <td colspan="8" style="{{ $indi == 1 ? 'border-bottom: 2px solid #008000' : '' }}" class=" {{ $indi == 1 ? 'anchoDetaD4' : 'anchoDetaD3' }}"><b class="tamaSaltoD">&nbsp;<br></b>{!! mb_strtoupper($c->resultado1, 'UTF-8') !!} @if($indi == 1)<b class="tamaSalto"><br>&nbsp;</b>@endif</td>
        
    </tr>
    @endif
    @if($c->campo2 === null || $c->campo2 === '')
        
    @else
    <tr>
        <td colspan="1" class="anchoLinea"></td>
        <td colspan="1" style="width:5px" class="lineaVerdeSinAltura"></td>
        <td colspan="5" class="anchoDetaI lineaVerdeSinAltura"><b class="tamaSalto">&nbsp;<br></b><b>{!! mb_strtoupper($c->campo2, 'UTF-8') !!}</b></td>
        <td colspan="1" style="width:10px" class="lineaVerdeSinAltura" >:</td>
        <td colspan="8"  class="anchoDetaD4" style="border-bottom: 2px solid #008000;"><b class="tamaSalto">&nbsp;<br></b>
        {!! mb_strtoupper($c->resultado2, 'UTF-8') !!}
                <b class="tamaSalto"><br>&nbsp;</b>
            </td>
    </tr>
    @endif

    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde2 anchoCabe"><b class="saltoLineaM">&nbsp;<br></b><b>3.   ALCANCE DE INSPECCIÓN: </b></td>
    </tr>
    <tr>
        <td colspan="1" class="anchoLinea"></td>
        <td colspan="1" style="width:10px" class="lineaVerdeSinAltura">@php($array = explode(',', $c->normativa))</td>
        <td colspan="12"  style="width:460px;"  class="lineaVerdeSinAltura"><b class="saltoLineaM">&nbsp;<br></b>        
        Certificar la operatividad y pruebas del equipo de acuerdo a los requisitos normativos en lo aplicable:<br>
        
        @foreach($array as $key => $item)
        - {!! mb_strtoupper($item, 'UTF-8') !!}@if($key < count($array) - 1).<br>@endif
    @endforeach
        <b class="saltoLineaM">&nbsp;</b></td>
        <td colspan="2"></td>
    </tr>

    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde2 anchoCabe"><b class="saltoLineaM">&nbsp;<br></b><b>4.   PARAMETROS DE PRUEBA DE CARGA: </b></td>
    </tr>
    <tr>
        <td colspan="2" style="width:95px"></td>
        <td colspan="5" class="anchoDetaI"><b class="tamaSalto">&nbsp;<br></b><b>CAPAC. NOMINAL DE PRUEBA(TABLA)</b></td>
        <td colspan="1" style="width:10px">:</td>
        <td colspan="8" class="anchoDetaD2" style="margin: 20px !important;"><b class="tamaSaltoD">&nbsp;<br></b>
                @if($c->capa_maxima === null || $c->capa_maxima === '')
                    N/A 
                @else
                    {!! mb_strtoupper($c->capa_maxima, 'UTF-8') !!}
                @endif
        </td>
    </tr>
    @php($indiPara=0)
    @if($c->tasa_prueba != '-')
        @php($indiPara=1)
    @endif
    @if($c->longitud_pluma != '-')
        @php($indiPara=2)
    @endif
    @if($c->angulo_pluma != '-')
        @php($indiPara=3)
    @endif
    @if($c->radio_opera != '-')
        @php($indiPara=4)
    @endif


        <tr>
            @if($indiPara == 0)
            <td colspan="1" class="anchoLinea"></td>
            @endif
            <td colspan="{{ $indiPara == 0 ? 1 : 2 }}" style="{{ $indiPara == 0 ? 'width:5px' : 'width:95px' }}"  class="{{ $indiPara == 0 ? 'lineaVerdeSinAltura' : '' }}"></td>
            <td colspan="5" class="anchoDetaI {{ $indiPara == 0 ? 'lineaVerdeSinAltura' : '' }}"><b class="tamaSalto">&nbsp;<br></b><b>PESO DE CERTIFICACIÓN</b></td>
            <td colspan="1" style="width:10px" class="{{ $indiPara == 0 ? 'lineaVerdeSinAltura' : '' }}">:</td>
            <td colspan="8" style="{{ $indiPara == 0 ? 'border-bottom: 2px solid #008000' : '' }}" class=" {{ $indiPara == 0 ? 'anchoDetaD4' : 'anchoDetaD3' }}"><b class="tamaSaltoD">&nbsp;<br></b>
                @if($c->peso_certificacion === null || $c->peso_certificacion === '')
                    N/A 
                @else
                    {!! mb_strtoupper($c->peso_certificacion, 'UTF-8') !!}
                @endif @if($indiPara == 0)<b class="tamaSalto"><br>&nbsp;</b>@endif</td>
            
        </tr>
    @if($c->tasa_prueba != '-')
        
        <tr>
            @if($indiPara == 1)
            <td colspan="1" class="anchoLinea"></td>
            @endif
            <td colspan="{{ $indiPara == 1 ? 1 : 2 }}" style="{{ $indiPara == 1 ? 'width:5px' : 'width:95px' }}"  class="{{ $indiPara == 1 ? 'lineaVerdeSinAltura' : '' }}"></td>
            <td colspan="5" class="anchoDetaI {{ $indiPara == 1 ? 'lineaVerdeSinAltura' : '' }}"><b class="tamaSalto">&nbsp;<br></b><b>PORCENTAJE DE PRUEBA</b></td>
            <td colspan="1" style="width:10px" class="{{ $indiPara == 1 ? 'lineaVerdeSinAltura' : '' }}">:</td>
            <td colspan="8" style="{{ $indiPara == 1 ? 'border-bottom: 2px solid #008000' : '' }}" class=" {{ $indiPara == 1 ? 'anchoDetaD4' : 'anchoDetaD3' }}"><b class="tamaSaltoD">&nbsp;<br></b>
                @if($c->tasa_prueba === null || $c->tasa_prueba === '')
                    N/A 
                @else
                    {!! mb_strtoupper($c->tasa_prueba, 'UTF-8') !!}
                @endif @if($indiPara == 1)<b class="tamaSalto"><br>&nbsp;</b>@endif</td>
            
        </tr>
    @endif
    @if($c->longitud_pluma != '-')
        <tr>
            @if($indiPara == 2)
            <td colspan="1" class="anchoLinea"></td>
            @endif
            <td colspan="{{ $indiPara == 2 ? 1 : 2 }}" style="{{ $indiPara == 2 ? 'width:5px' : 'width:95px' }}"  class="{{ $indiPara == 2 ? 'lineaVerdeSinAltura' : '' }}"></td>
            <td colspan="5" class="anchoDetaI {{ $indiPara == 2 ? 'lineaVerdeSinAltura' : '' }}"><b class="tamaSalto">&nbsp;<br></b><b>LONGITUD DE PLUMA </b></td>
            <td colspan="1" style="width:10px" class="{{ $indiPara == 2 ? 'lineaVerdeSinAltura' : '' }}">:</td>
            <td colspan="8" style="{{ $indiPara == 2 ? 'border-bottom: 2px solid #008000' : '' }}" class=" {{ $indiPara == 2 ? 'anchoDetaD4' : 'anchoDetaD3' }}"><b class="tamaSaltoD">&nbsp;<br></b>
                @if($c->longitud_pluma === null || $c->longitud_pluma === '')
                        N/A 
                    @else
                        {!! mb_strtoupper($c->longitud_pluma, 'UTF-8') !!}
                    @endif @if($indiPara == 2)<b class="tamaSalto"><br>&nbsp;</b>@endif</td>
        </tr>
    @endif
    @if($c->angulo_pluma != '-')
        <tr>
            @if($indiPara == 3)
            <td colspan="1" class="anchoLinea"></td>
            @endif
            <td colspan="{{ $indiPara == 3 ? 1 : 2 }}" style="{{ $indiPara == 3 ? 'width:5px' : 'width:95px' }}"  class="{{ $indiPara == 3 ? 'lineaVerdeSinAltura' : '' }}"></td>
            <td colspan="5" class="anchoDetaI {{ $indiPara == 3 ? 'lineaVerdeSinAltura' : '' }}"><b class="tamaSalto">&nbsp;<br></b><b>ANGULO DE PLUMA</b></td>
            <td colspan="1" style="width:10px" class="{{ $indiPara == 3 ? 'lineaVerdeSinAltura' : '' }}">:</td>
            <td colspan="8" style="{{ $indiPara == 3 ? 'border-bottom: 2px solid #008000' : '' }}" class=" {{ $indiPara == 3 ? 'anchoDetaD4' : 'anchoDetaD3' }}"><b class="tamaSaltoD">&nbsp;<br></b>
                @if($c->angulo_pluma === null || $c->angulo_pluma === '')
                        N/A 
                    @else
                        {!! mb_strtoupper($c->angulo_pluma, 'UTF-8') !!}
                    @endif @if($indiPara == 3)<b class="tamaSalto"><br>&nbsp;</b>@endif</td>
        </tr>
    @endif
    @if($c->radio_opera != '-')
        <tr>
            @if($indiPara == 4)
            <td colspan="1" class="anchoLinea"></td>
            @endif
            <td colspan="{{ $indiPara == 4 ? 1 : 2 }}" style="{{ $indiPara == 4 ? 'width:5px' : 'width:95px' }}"  class="{{ $indiPara == 4 ? 'lineaVerdeSinAltura' : '' }}"></td>
            <td colspan="5" class="anchoDetaI {{ $indiPara == 4 ? 'lineaVerdeSinAltura' : '' }}"><b class="tamaSalto">&nbsp;<br></b><b>RADIO OPERATIVO</b></td>
            <td colspan="1" style="width:10px" class="{{ $indiPara == 4 ? 'lineaVerdeSinAltura' : '' }}">:</td>
            <td colspan="8" style="{{ $indiPara == 4 ? 'border-bottom: 2px solid #008000' : '' }}" class=" {{ $indiPara == 4 ? 'anchoDetaD4' : 'anchoDetaD3' }}"><b class="tamaSalto">&nbsp;<br></b>
                    @if($c->radio_opera === null || $c->radio_opera === '')
                        N/A 
                    @else
                        {!! mb_strtoupper($c->radio_opera, 'UTF-8') !!}
                    @endif @if($indiPara == 4)<b class="tamaSalto"><br>&nbsp;</b>@endif</td>
        </tr>
    @endif
    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde2 anchoCabe"><b class="saltoLineaM">&nbsp;<br></b><b>5.   CONCLUSIONES: </b></td>
    </tr>
    <tr>
        <td colspan="1" class="anchoLinea"></td>
        <td colspan="1" style="width:10px" class="lineaVerdeSinAltura"></td> 
        <td colspan="12" style="width:460px;" class="lineaVerdeSinAltura"><font class="tamaSaltoS56"><br/><font style="font-size:9.5pt; text-align: justify;">
        El equipo descrito en el ítem 2 se encuentra en CONDICIONES DE OPERATIVIDAD CONFORME AL ALCANCE descrito en el ítem 3. La información contenida en este certificado es un resumen de lo declarado en el Informe de Inspección de Operatividad Nro. {!! strtoupper($c->informe) !!} En el cual, refleja todos los valores, observaciones y los resultados obtenidos, en el lugar y fecha definidos en este Certificado.
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
        <td colspan="12" style="width:460px" class="lineaVerdeSinAltura"><font class="tamaSaltoS56"><br><font style="font-size:9.5pt; text-align: justify;">El presente certificado tiene vigencia de {!! mb_strtoupper($c->vigencia, 'UTF-8') !!} desde la fecha de emisión.  
Pierde validez en caso, existan cambios o alteraciones en el equipo que afecten su operatividad.
    </font><br/></font></td>
    <td colspan="2" ></td>
    </tr>
    <tr>
        <td colspan="2" class="anchoLinea"></td>
        <td colspan="13" class="lineaVerde2SinBorde anchoCabe"><b class="saltoLineaM">&nbsp;<br></b><b>7.   APROBADO POR: </b></td>
    </tr>
    <tr>
        <td colspan="2" style="height:45px"></td>
    </tr>
    <tr>
        <td colspan="2" style="width:115px;"></td>
        
        <td colspan="14"><b></b></td>
    </tr>
</tbody>
    @endforeach
    </table>
</div>
</body>
</html>