<?php

include('loginSesion.php'); 

// Recoge los datos que vienen de la hora seleccionada
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pista = $_POST['id_pista'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
} else {
    // Si intentan entrar escribiendo la URL a mano, de vuelta al login
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pistas Jacarilla - Método de Pago</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link rel="stylesheet" href="css/inicioSesion.css">
    <link rel="stylesheet" href="css/pago.css">
</head>

<body>

    <header>
        <div class="logo">
            <img src="fotos/logo_sin_fondo.png" alt="Pistas Jacarilla">
        </div>
    </header>

    <div class="inicioSesionEntero">
        <div class="overlay">
            <div class="inicioSesion">
                <h2>Método de Pago</h2>
                
                <p class="texto-info">
                    Vas a reservar para el día <br>
                    <strong><?php echo htmlspecialchars($fecha); ?></strong> a las <strong><?php echo htmlspecialchars($hora); ?></strong>
                </p>
                
                <form action="reservas.php" method="POST">
                    <input type="hidden" name="id_pista" value="<?php echo $id_pista; ?>">
                    <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                    <input type="hidden" name="hora" value="<?php echo $hora; ?>">
                    
                    <button type="submit" name="metodo_pago" value="Tarjeta" class="btn-pago tarjeta">Pagar con Tarjeta</button>
                    <button type="submit" name="metodo_pago" value="Efectivo" class="btn-pago efectivo">Pagar en Efectivo</button>
                </form>
                
                <p><a href="index.php">Cancelar y volver</a></p>
            </div>
        </div>
    </div>

</body>
</html>