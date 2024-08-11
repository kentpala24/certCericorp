<p style="text-align:right;font-size:0.5pt;">&nbsp;</p>
<table>
@foreach ($carnes as $c)
<tr>
        <td style="font-size:6pt;width:36px; height:21px"></td>
        <td></td>
    </tr>

    
    <tr>
        <td style="font-size:6pt;width:38px"></td>
        @if($c->idtipo_certificado==8 || $c->idtipo_certificado==10)
        <td style="font-size:5.8pt;width:200px; height:19px ">Requirements for this certificate of Completion are under current applicability:
        <br/><br/>{{ $c->normativa_espanol }}.<br/></td>
        
        @else
        <td style="font-size:5.5t;width:175px; height:19px "> <br/><br/><br/><br/> <br/>      <strong> {{$c->identifica}}.</strong></td>
        @endif
</tr>

<tr>
        <td style="font-size:5pt;width:55px"></td>
        <td style="font-size:5pt;width:175px; height:14px "><br/><br/><strong>
@if($c->level=="Intermediate Level" || $c->nivel=="Intermediate Level")
Intermedio.
@elseif($c->level=="Basic Level" || $c->nivel=="Basic Level")
Básico.
@endif</strong>
</td>
</tr>
<tr>
        <td style="font-size:5pt;width:32px">

</td>
        @if($c->idtipo_certificado==8 || $c->idtipo_certificado==10)
        <td style="font-size:5pt;width:205px; height:14px ">&nbsp;<td style="font-size:5pt;width:175px; height:14px ">
</td>
@endif
</tr>
@if($c->idtipo_certificado!=8 && $c->idtipo_certificado!=10 )
<tr>
        <td style="font-size:5pt;width:32px"></td>
        <td style="font-size:5pt;width:175px; height:14px ">&nbsp;</td>
</tr>
<tr>
        <td style="font-size:5pt;width:32px"></td>
        <td style="font-size:5pt;width:175px; height:7px ">&nbsp;</td>
</tr>
@else
<tr>
        <td style="font-size:5pt;width:32px"></td>
        <td style="font-size:5pt;width:200px; height:14px "><br/><br/>
Issued to Company / Holder: {{$c->empresa}}<br/></td>
</tr>
@endif
@if($c->idtipo_certificado==8 || $c->idtipo_certificado==10)
<tr>
        <td style="font-size:5pt;width:32px"></td>
        <td style="font-size:5pt;width:200px; height:12px ">
A photocopy of this card is NOT acceptable for identification.</td>
</tr>
@else
<tr>
        <td style="font-size:5pt;width:32px"></td>
        <td style="font-size:5pt;width:175px; height:12px ">&nbsp;</td>
</tr>
<tr>
        <td style="font-size:6pt;width:32px"></td>
        <td style="font-size:5pt;width:200px; height:12px ">
</td>
</tr>
@endif

@endforeach
</table>   
</body>
