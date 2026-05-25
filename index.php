<?php
// Configuración de la conexión a tu base de datos de XAMPP
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "reservas_deportivas";

try {
    // Creamos la conexión PDO
    $conexion = new PDO("mysql:host=$host;dbname=$base_datos;charset=utf8", $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Hacemos la consulta para traer a los usuarios (como Manolo)
    $consulta = $conexion->query("SELECT * FROM usuarios");
    $lista_usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Si falla la conexión, te mostrará el error en la pantalla
    die("Error de conexión con la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pistas Jacarilla</title>
    <link rel="stylesheet" href="inicio.css">
</head>

<body>

<header>
    <div class="menu">☰</div>

    <div class="logo">
        <img src="logo_sin_fondo.png" alt="Logo">
    </div>

    <a href="inicioSesion.html" class="usuario">👤</a>
</header>

<main>
    <div class="overlay">

        <h1>Reservar pista</h1>
        <p class="subtitulo">Selecciona deporte y horario</p>

        <div class="filtros">
            <div class="selector">
                📅 <span><strong>Fecha:</strong> 01 enero 2026</span>
                <span class="flecha">▾</span>
            </div>

            <div class="selector">
                🕒 <span><strong>Hora:</strong> Seleccionar</span>
                <span class="flecha">▾</span>
            </div>
        </div>

        <div class="tarjetas">
            
            <a href="horarioFut.html" class="card futbol">
                <div class="contenido">
                    <h3>FÚTBOL</h3>
                    <p>3 pistas disponibles</p>
                    <span class="precio">Desde 30 €</span>
                </div>
            </a>

            <a href="horarioTenis.html" class="card tenis">
                <div class="contenido">
                    <h3>TENIS</h3>
                    <p>3 pistas disponibles</p>
                    <span class="precio">Desde 25 €</span>
                </div>
            </a>

            <a href="horarioBasket.html" class="card baloncesto">
                <div class="contenido">
                    <h3>BALONCESTO</h3>
                    <p>3 pistas disponibles</p>
                    <span class="precio">Desde 27 €</span>
                </div>
            </a>
        </div>
    </div>
</main>

</body>
</html>