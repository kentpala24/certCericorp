<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSULTA SOBRE CERTIFICACIÓN</title>
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
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
}

form {
    text-align: center;
}

label {
    font-weight: bold;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
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
.logo {
    text-align: center;
    margin-bottom: 20px;
}
</style>

<body>
    <div class="container">
        <div class="logo">
            <img src="https://certificado.cericorp.com/img/logo.png" alt="Logo" width="242" height="60">
        </div>
        <h1>CONSULTA SOBRE CERTIFICACIÓN</h1>
        <form action="/verificar" method="get" >
            
                        <div class="col-md-12">
                            <h4>DOCUMENTO IDENTIDAD: &nbsp;</h4>
                        
                                <input type="text" class="group-control" id="dni" name="dni" required autofocus>
                        </div>
                        <div class="col-md-12">
                        <h4>Nº CERTIFICACIÓN: &nbsp;</h4>
                            <input type="text" class="group-control" id="certificado" name="certificado" required>
                        </div>
                            <?php
                            if(isset($cont)){
                                echo "Certificado No Encontrado";
                            }
                            ?>
            <button type="submit">Consultar</button>
        </form>
        <p><strong>CERICORP PERU</strong><br>
        Para consultar acerca del estado de su certificacion escribir a: <a href="mailto:informes@certestingperu.com">ventas@cericorp.com</a><br>
        Copyright © 2024 , All Rights Reserved</p>
    </div>
</body>
</html>
