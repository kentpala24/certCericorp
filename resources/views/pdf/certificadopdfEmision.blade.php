<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado Digital</title>
</head>
<body>
<div id="background">
@foreach ($certificados as $c)

<style>
        
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
        }
        
        
        td.certi{
            text-align: center;
        }
        td.certific{
            text-align: center;
            line-height : 100px;
        }
        td.certifi{
            text-align: center;
            padding-top: 13px;
            
        }
        
        td.tope{
            text-align: center;
            padding-top: 100px;
            
        }
        
       
       
        
    </style>
    @endforeach
    <table width="100%" height="100%">
    @foreach ($certificados as $c)
    <thead>
        
    </thead>
    <tbody>
    <tr style="height:20px">
    
        <td colspan="13"></td>
        <td colspan="2" style="height:135px"><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p>&nbsp;</p><br><br></td>
        <td colspan="1"></td>
    </tr>
    
    <tr><td colspan="16" class="tope">{!! str_replace("ñ", "Ñ", strtoupper($c->cabecera)) !!}</td></tr>
    <tr>
        <td colspan="8"><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td>
        <td colspan="7" class="certific" style="height:135px"><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td>
    </tr>
    <tr class="certi">
    <td colspan="4" style="width:55px"></td>
    <td colspan="1" style="width:198px"><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CERTIFICATE: P - {{$c->certificado}} <br><br>{!! $c->fecha !!}</td>
        
        <td colspan="8" style="width:535px" class="certifi"><p>&nbsp;</p><p><br>{!! $c->description !!}</p> 
        
        </td>
    </tr>
    </tbody>
    @endforeach
    </table>
</div>
</body>
</html>