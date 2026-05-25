<?php

try {
    # Creamos la conexión PDO

    $host='localhost';
    $dbname='reservas_deportivas';
    $user='root';
    $pass='';

    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

    $conexion ->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    # echo "Conexión realizada con éxito.";

} catch (PDOException $e) {
    # Si falla la conexión, te mostrará el error en la pantalla
    die("Error de conexión con la base de datos: " . $e->getMessage());
}
?>