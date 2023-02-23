<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'facturacion';

    // Realiza la conexión con la base de datos
    $conection = @mysqli_connect($host,$user,$password,$db);

    if(!$conection){
        echo "Error conection";
    }

?>