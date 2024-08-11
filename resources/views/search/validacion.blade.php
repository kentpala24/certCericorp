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
            @foreach($certificados as $c)
            <H4>INFORMACIÓN GENERAL:</H4>
                        <li data-before="Nº de Certificado:"><strong>{!! strtoupper(str_replace('/', '|', $c->cod_certificado)) !!}</strong></li>
                        
                        <li data-before="CLIENTE:">{!! strtoupper($c->empresa) !!}</li>
                        
                        <li data-before="LUGAR DE EVALUACIÓN:">{!! strtoupper($c->lugar) !!}</li>
                        
                        <li data-before="FECHA DE EVALUACIÓN:">{{ date("d/m/Y", strtotime($c->fecha_emision))}}</li>
                        
                        <li data-before="FECHA DE EMISIÓN CERTIFICADO:">{{ date("d/m/Y", strtotime($c->fecha_emision7))}}</li>
                        
            <H4>DATOS DEL PERSONAL EVALUADO:</H4>            
                        <li data-before="APELLIDOS:">{!! strtoupper($c->apellido) !!}</li>
                        
                        <li data-before="NOMBRES:">{!! strtoupper($c->nombre) !!}</li>
                        
                        <li data-before="DNI / PASAPORTE:">{!! strtoupper($c->dni) !!}</li>
                        
                        <li data-before="CALIFICACIÓN:">{!! mb_strtoupper($c->identifica, 'UTF-8') !!}</li>
            <H4>DATOS DE LA EVALUACIÓN:</H4>              
                        <li data-before="RESULTADO:">{!! strtoupper($c->resultado) !!}</li>
                        
                        <li data-before="CAPACIDAD DE EQUIPO UTILIZADO:">{!! strtoupper($c->capacidad) !!}</li>
                        
                        <li data-before="TIPO DE EQUIPO:">{!! mb_strtoupper($c->horas, 'UTF-8') !!}</li>
                        
                        <li data-before="MARCA:">{!! strtoupper($c->equipo) !!}</li>
                        
                        <li data-before="MODELO:">{!! strtoupper($c->modelo) !!}</li>
                        
                        <li data-before="VIGENCIA:"><strong>{{ date("d/m/Y", strtotime($c->fecha_emision7))}}</strong> Hasta: <strong>{{ date("d/m/Y", strtotime($c->fecha_expiracion))}}</strong></li>
                        
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
                <form action="/search" method="get" >
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

