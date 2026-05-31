<?php
session_start();

// Si el usuario pulsa el botón de cerrar sesión
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();     // Vacía los datos
    session_destroy();   // Destruye la sesión
    header("Location: ../login.php"); // Y es devuelto al login
    exit;
}

// Si no ha iniciado sesión, o si ha iniciado sesión pero no es admin (es 0), es devuelto al login
if (!isset($_SESSION['id']) || $_SESSION['admin'] != 1) {
    header("Location: ../login.php");
    exit;
}

try {
    include('../conexion.php');

    // Cuenta los usuarios totales
    $sqlUsuarios = "SELECT COUNT(*) AS total_users FROM usuarios"; /* La query */
    $stmtUsers = $conexion->query($sqlUsuarios); /* La conexion manda la query, y se guarda el resultado de la búsqueda en stmtUsers como paquete */
    $totalUsuarios = $stmtUsers->fetch(PDO::FETCH_ASSOC)['total_users']; /* El fetch(PDO::FETCH_ASSOC) abre el paquete y transforma el resultado en un array asociativo, y el total_users lee únicamente el número */

    // Cuenta las pistas activas
    $sqlPistas = "SELECT COUNT(*) AS total_pistas FROM pistas";
    $stmtPistas = $conexion->query($sqlPistas);
    $totalPistas = $stmtPistas->fetch(PDO::FETCH_ASSOC)['total_pistas'];

    // Cuenta las reservas activas
    $sqlReservas = "SELECT COUNT(*) AS total_reservas FROM reservas";
    $stmtReservas = $conexion->query($sqlReservas);
    $totalReservas = $stmtReservas->fetch(PDO::FETCH_ASSOC)['total_reservas'];

} catch (PDOException $e) {
    // Si una de las consultas falla, aparecerá con un 0 pero el sistema seguirá funcionando
    $totalUsuarios = 0;
    $totalPistas = 0;
    $totalReservas = 0;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Control - Pistas Jacarilla</title>
    <link rel="stylesheet" href="panelAdmin.css">
    <link rel="icon" type="image/png" href="../logo.png">
</head>
<body>

    <div class="contenedor-panel">
        
        <aside class="barra-lateral">
            <div class="logo-admin">
                <img src="../fotos/logo_sin_fondo.png" alt="Logo">
            </div>
            <nav class="menu-admin">
                <a href="#" class="active">📊 Panel Principal</a>
                <a href="#">📅 Reservas Activas</a>
                <a href="editorUsuarios.php">👥 Usuarios</a>
                <a href="#">🎾 Gestionar Pistas (PRÓXIMAMENTE)</a>
                <a href="../index.php" class="btn-volver">Visitar la Web</a>
            </nav>
        </aside>

        <main class="contenido-principal">
            <header class="header-top">
                <h2>Panel de Administración</h2>
                <div class="usuario-info">
                    <span>Bienvenido, <strong><?php echo $_SESSION['nombre']; ?></strong></span>
                    <a href="panelAdmin.php?action=logout" class="btn-cerrar">Cerrar Sesión</a>
                </div>
            </header>

            <section class="tarjetas-resumen">
                <div class="tarjeta">
                    <h3>Reservas Activas</h3>
                    <p class="numero"><?php echo $totalReservas; ?></p>
                </div>
                <div class="tarjeta">
                    <h3>Usuarios Totales</h3>
                    <p class="numero"><?php echo $totalUsuarios; ?></p>
                </div>
                <div class="tarjeta">
                    <h3>Pistas Activas</h3>
                    <p class="numero"><?php echo $totalPistas; ?></p>
                </div>
            </section>
        </main>

    </div>

</body>
</html>