<?php
include('loginSesion.php');

include('conexion.php');

$email_sesion = $_SESSION['email'];

try {
    // Buscamos los datos actualizados del usuario en la base de datos
    $sql = "SELECT nombre, email FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$email_sesion]);
    $usuario_datos = $stmt->fetch(PDO::FETCH_ASSOC);

    $nombre_usuario = $usuario_datos['nombre'];
    $_SESSION['nombre'] = $nombre_usuario; // Esta session ha hecho falta para poder mostrar el nombre en el perfil de las pistas

} catch (PDOException $e) {
    echo "Error al cargar el perfil: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pistas Jacarilla</title>
        <link rel="stylesheet" href="css/inicio.css">
    </head>

    <body>

        <?php
            include ('navegador.php');
        ?>

        <main>
            <div class="overlay">

                <h1>Reservar pista</h1>
                <p class="subtitulo">Selecciona deporte y horario</p>

                <div class="filtros">
                    <div class="selector" id="fecha_reservas">
                        <form action="index.php" method="POST">
                            <label></label>
                            <input type="date" id="fecha" name="fecha_actual" min="<?php echo date('Y-m-d')?>" required onchange="this.form.action = 'index.php#fecha_reservas'; $this.form.submit();">
                        </form>
                        <!--📅 <span><strong>Fecha:</strong> 01 enero 2026</span>
                        <span class="flecha">▾</span>-->
                    </div>
                </div>

                <div class="tarjetas">
                    
                    <a href="horarioFut.php" class="card futbol">
                        <div class="contenido">
                            <h3>FÚTBOL</h3>
                            <p>3 pistas disponibles</p>
                            <span class="precio">Desde 30 €</span>
                        </div>
                    </a>

                    <a href="horarioTenis.php" class="card tenis">
                        <div class="contenido">
                            <h3>TENIS</h3>
                            <p>3 pistas disponibles</p>
                            <span class="precio">Desde 25 €</span>
                        </div>
                    </a>

                    <a href="horarioBasket.php" class="card baloncesto">
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