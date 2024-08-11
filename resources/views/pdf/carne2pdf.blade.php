<p style="text-align:right;font-size:0.5pt;">&nbsp;</p>
<table>
@foreach ($carnes as $c)
<tr>
        <td style="font-size:6pt;width:36px; height:15px"></td>
        <td></td>
    </tr>

    
    <tr>
        <td style="font-size:6pt;width:32px"></td>
        @if($c->idtipo_certificado==8 || $c->idtipo_certificado==10)
        <td style="font-size:5.8pt;width:200px; height:19px ">Requirements for this certificate of Completion are under current applicability:
        <br/><br/>{{ $c->normativa_espanol }}.<br/></td>
        
        @else
        <td style="font-size:5.8pt;width:200px; height:19px ">Los requerimientos técnicos y normativos para esta certificación están bajo el
(los) lineamiento(s) del estándar(es) aplicable(s) vigente(s): <br/>{{ $c->normativa_espanol }}.</td>
        @endif
</tr>

<tr>
        <td style="font-size:6pt;width:32px"></td>
        <td style="font-size:5.8pt;width:200px; height:14px ">
@if($c->idtipo_certificado==8 || $c->idtipo_certificado==10)
This person is not employed by and does not represent CICB.
@elseif($c->idtipo_certificado==7)
<br/><br/>El carné de uso personal e identificará al portador como {{$c->identifica}} en el(los) tipo(s) de equipo(s) indicado(s).
@else
El carné de uso personal e identificará al portador como {{$c->identifica}} en el(los) tipo(s) de equipo(s) indicado(s).
@endif
</td>
</tr>
<tr>
        <td style="font-size:6pt;width:32px"></td>
        @if($c->idtipo_certificado==8 || $c->idtipo_certificado==10)
        <td style="font-size:5.8pt;width:205px; height:14px ">
If you have any questions regarding the status of the card holder contact: <br/>
E-mail: certificaciones@cicbla.com | serviciospe@cicbla.com <br/><br/>Validity inquiries on the website: www.cicbla.com | {{$c->dni}} | P-{{$c->certificado}}</td>
        @elseif($c->idtipo_certificado==7)
        @else
        <td style="font-size:5.6pt;width:205px; height:14px ">
@if($c->level=="Intermediate Level" || $c->nivel=="Intermediate Level")
Nivel Intermedio: Calificado en operaciones rutinarias, excepto para operaciones especiales (críticos).
@elseif($c->level=="Basic Level" || $c->nivel=="Basic Level")
Nivel Básico: Calificado en operaciones rutinarias, excepto para operaciones especiales (críticos).
@elseif($c->level=="Nivel 1" || $c->nivel=="Nivel 1")
Nivel I: Calificado en operaciones rutinarias, excepto para operaciones especiales (críticos).
@endif</td>
@endif
</tr>
@if($c->idtipo_certificado!=8 && $c->idtipo_certificado!=10 )
<tr>
        <td style="font-size:6pt;width:32px"></td>
        <td style="font-size:5.8pt;width:200px; height:14px ">
Cualquier consulta sobre el estado del titular de este carné contactarnos a: <br>E-mail: certificaciones@cicbla.com | serviciospe@cicbla.com</td>
</tr>
<tr>
        <td style="font-size:6pt;width:32px"></td>
        <td style="font-size:5.8pt;width:200px; height:7px ">
@if($hola==4)
Consultas de vigencia en el sitio web: www.cicbla.com | {{$c->dni}} | P-{{$c->numero}}
@else
Consultas de vigencia en el sitio web: www.cicbla.com | {{$c->dni}} | P-{{$c->certificado}}
@endif</td>
</tr>
@else
<tr>
        <td style="font-size:6pt;width:32px"></td>
        <td style="font-size:5.8pt;width:200px; height:14px "><br/><br/>
Issued to Company / Holder: {{$c->empresa}}<br/></td>
</tr>
@endif
@if($c->idtipo_certificado==8 || $c->idtipo_certificado==10)
<tr>
        <td style="font-size:6pt;width:32px"></td>
        <td style="font-size:5.8pt;width:200px; height:12px ">
A photocopy of this card is NOT acceptable for identification.</td>
</tr>
@else
<tr>
        <td style="font-size:6pt;width:32px"></td>
        <td style="font-size:5.8pt;width:200px; height:12px ">
La copia de este carné NO es aceptable para propósitos de identificación.</td>
</tr>
<tr>
        <td style="font-size:6pt;width:32px"></td>
        <td style="font-size:5.8pt;width:200px; height:12px ">
Firma Autorizada.</td>
</tr>
@endif

@endforeach
</table>   
</body>
