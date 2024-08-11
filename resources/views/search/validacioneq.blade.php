<!DOCTYPE html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Consulta de Certificados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    background-color: #f8f8f8;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #d66400;
}

.pdf-section, .info-section {
    margin-bottom: 30px;
}

.pdf-section h2, .info-section h2 {
    border-bottom: 2px solid #d66400;
    padding-bottom: 10px;
}

ul {
    list-style: none;
    padding: 0;
}

ul li {
    margin-bottom: 10px;
}

iframe {
    border: 2px solid #d66400;
    border-radius: 10px;
    width: 100%;
    height: 500px;
}

.info-section ul li {
    border-left: 4px solid #d66400;
    padding-left: 10px;
    margin-left: 10px;
}

.info-section ul li strong {
    color: #d66400;
}

.info-section ul li strong {
    color: black; /* Cambiado a negro */
    font-weight: bold;
}

.info-section ul li::before {
    content: attr(data-before);
    font-weight: bold;
    color: #d66400;
}


.logo {
    text-align: center;
    margin-bottom: 20px;
}

.pdfContainer {
    border: 2px solid #d66400;
    border-radius: 10px;
    width: 100%;
    height: 500px;
    margin: 0 auto;
    
}
button {
    background-color: #d66400; /* Nuevo color del botón */
    color: white;
    padding: 14px 20px;
    margin: 10px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #b45200; /* Cambio de color al pasar el cursor sobre el botón */
}

button:active {
    background-color: #944000; /* Cambio de color al hacer clic en el botón */
}

</style>

<body>
    <div class="container">
        <div class="logo">
            <img src="https://certificado.cericorp.com/img/logo.png" alt="Logo" width="242" height="60">
        </div>
        <h1>Resultado de Consulta de Certificados</h1>
        
        <div class="info-section">
            <h2>Detalles del Certificado</h2>
            <ul>
            @foreach($equipos as $c)
            <H4>INFORMACIÓN GENERAL:</H4>
                        <li data-before="Nº de Certificado:"><strong>{!! strtoupper(str_replace('/', '|', $c->certificado)) !!}</strong></li>
                        
                        <li data-before="CLIENTE:">{!! strtoupper($c->cliente) !!}</li>
                        
                        <li data-before="LUGAR DE INSPECCIÓN:">{!! strtoupper($c->lugar) !!}</li>
                        
                        <li data-before="FECHA DE INSPECCIÓN:">{{ date("d/m/Y", strtotime($c->fecha_inspeccion))}}</li>
                        
                        <li data-before="FECHA DE EMISIÓN CERTIFICADO:">{{ date("d/m/Y", strtotime($c->fecha_emision))}}</li>
                        
            <H4>IDENTIFICACIÓN DEL EQUIPO:</H4>            
                        <li data-before="TIPO DE EQUIPO:">{!! mb_strtoupper($c->tipo_equipo, 'UTF-8') !!}</li>
                        
                        <li data-before="MARCA:">{!! strtoupper($c->marca) !!}</li>
                        
                        <li data-before="MODELO:">{!! mb_strtoupper($c->modelo, 'UTF-8') !!}</li>
                        
                        <li data-before="NUMERO DE SERIE:">{!! mb_strtoupper($c->serie, 'UTF-8') !!}</li>
            <H4>PARAMETROS DE PRUEBA DE CARGA:</H4>              
                        <li data-before="CAPACIDAD MÁXIMA NOMINAL:">
                            @if($c->capa_maxima === null || $c->capa_maxima === '')
                                N/A 
                            @else
                                {!! mb_strtoupper($c->capa_maxima, 'UTF-8') !!}
                            @endif
                        </li>
                        
                        <li data-before="PESO DE CERTIFICACIÓN:">
                            @if($c->peso_certificacion === null || $c->peso_certificacion === '')
                                N/A 
                            @else
                                {!! mb_strtoupper($c->peso_certificacion, 'UTF-8') !!}
                            @endif
                        </li>
                        
                        <li data-before="PORCENTAJE DE PRUEBA:">
                            @if($c->tasa_prueba === null || $c->tasa_prueba === '')
                                N/A 
                            @else
                                {!! mb_strtoupper($c->tasa_prueba, 'UTF-8') !!}
                            @endif
                        </li>
                        
                        
                        <li data-before="CONDICIÓN:"><?php
                        if($c->fecha_expiracion>date('Y-m-d')){
                            echo "<strong>VIGENTE</STRONG>";
                        }
                        else{
                            echo "<strong>VENCIDO</STRONG>";
                        }
                        ?></li>
                        
                        
                        
                        
            @endforeach
            </ul>
            <div class="col-md-9">
                <form action="/searcheq" method="get" >
                    <br><button type="submit" class="btn btn-primary">Volver a Consultar</button><br>
                </form>
            </div>
            <div class="col-md-9">
                <p><br><br><br><strong>CERICORP</strong> <br>
                    Para consultar acerca del estado de su certificacion escribir a: <br>
                    <a href = "mailto: ventas@cericorp.com">ventas@cericorp.com</a><br>
                    o Visite <strong><a href = "https://www.cericorp.com/"> www.cericorp.com</a></strong> <br>
                    Copyright © {{date("Y")}} , All Rights Reserved
                </p> 
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    
</html>

